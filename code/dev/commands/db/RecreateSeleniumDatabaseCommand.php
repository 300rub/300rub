<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
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
            ->createDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $this->_dbObject->getReadDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
                true
            )
            ->createDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $this->_dbObject->getWriteDbName(
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
                $this->_dbObject->getWriteDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
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

        $dbName = $config->getValue(['db', 'selenium', 'name']);
        $dbWriteName = App::getInstance()->getDb()->getWriteDbName(
            $dbName
        );
        $dbReadName = App::getInstance()->getDb()->getReadDbName(
            $dbName
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/%s.sql',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $dbWriteName,
                FILES_ROOT,
                $dbWriteName
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/%s.sql',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $dbReadName,
                FILES_ROOT,
                $dbWriteName
            )
        );

        return $this;
    }
}
