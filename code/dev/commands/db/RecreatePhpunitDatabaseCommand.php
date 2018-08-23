<?php

namespace ss\commands\db;

use ss\application\App;

use ss\commands\db\_abstract\AbstractDbCommand;

/**
 * Recreates Phpunit databases
 */
class RecreatePhpunitDatabaseCommand extends AbstractDbCommand
{

    /**
     * DB object
     *
     * @var Db
     */
    private $_dbObject = null;

    /**
     * DB host
     *
     * @var string
     */
    private $_dbHost = null;

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $this->checkConnection();

        $this->_dbObject = App::getInstance()->getDb();
        $this->_dbHost = $this->_dbObject->getRandomDbHost();

        $this
            ->_recreateDbs()
            ->_importSourceDb()
            ->_loadFixtures()
            ->_cloneDb();
    }

    /**
     * Recreates DBs
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _recreateDbs()
    {
        $config = App::getInstance()->getConfig();

        $this->_dbObject
            ->createNewDb(
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'password']),
                $config->getValue(['db', 'phpunit', 'name']),
                true
            )
            ->createNewDb(
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'password']),
                App::getInstance()->getDb()->getAdminDbName(
                    $config->getValue(['db', 'phpunit', 'name'])
                ),
                true
            );

        return $this;
    }

    /**
     * Imports source DB
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _importSourceDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $config->getValue(['db', 'phpunit', 'password']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'name']),
                Db::SOURCE_PATH
            )
        );

        return $this;
    }

    /**
     * Loads fixtures
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _loadFixtures()
    {
        $command = new ImportFixturesCommand();
        $command->setType('phpunit');
        $command->run();

        return $this;
    }

    /**
     * Clones DB
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _cloneDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/phpunit.sql',
                $config->getValue(['db', 'phpunit', 'password']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'name']),
                FILES_ROOT
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/phpunit.sql',
                $config->getValue(['db', 'phpunit', 'password']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'host']),
                App::getInstance()->getDb()->getAdminDbName(
                    $config->getValue(['db', 'phpunit', 'name'])
                ),
                FILES_ROOT
            )
        );

        return $this;
    }
}
