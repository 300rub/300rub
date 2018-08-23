<?php

namespace ss\commands\db;

use ss\application\App;

use ss\commands\db\_abstract\AbstractDbCommand;

/**
 * Recreates Selenium databases
 */
class RecreateSeleniumDatabaseCommand extends AbstractDbCommand
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
     * @return RecreateSeleniumDatabaseCommand
     */
    private function _recreateDbs()
    {
        $config = App::getInstance()->getConfig();

        $this->_dbObject
            ->createNewDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'name']),
                true
            )
            ->createNewDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                App::getInstance()->getDb()->getAdminDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
                true
            );

        return $this;
    }

    /**
     * Imports source DB
     *
     * @return RecreateSeleniumDatabaseCommand
     */
    private function _importSourceDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'name']),
                Db::SOURCE_PATH
            )
        );

        return $this;
    }

    /**
     * Loads fixtures
     *
     * @return RecreateSeleniumDatabaseCommand
     */
    private function _loadFixtures()
    {
        $command = new ImportFixturesCommand();
        $command->setType('selenium');
        $command->run();

        return $this;
    }

    /**
     * Clones DB
     *
     * @return RecreateSeleniumDatabaseCommand
     */
    private function _cloneDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/selenium.sql',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'name']),
                FILES_ROOT
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/selenium.sql',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                App::getInstance()->getDb()->getAdminDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
                FILES_ROOT
            )
        );

        return $this;
    }
}
