<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\Db;
use ss\commands\db\_abstract\AbstractDbCommand;

/**
 * Clear DB command
 */
class RecreateDevDatabaseCommand extends AbstractDbCommand
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
        $this->checkIsDev();
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
     * @return RecreateDevDatabaseCommand
     */
    private function _recreateDbs()
    {
        $config = App::getInstance()->getConfig();

        $this->_dbObject
            ->createNewDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'name']),
                true
            )
            ->createNewDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'name']) . 'Admin',
                true
            );

        return $this;
    }

    /**
     * Imports source DB
     *
     * @return RecreateDevDatabaseCommand
     */
    private function _importSourceDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/source.sql',
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'name']),
                FILES_ROOT
            )
        );

        return $this;
    }

    /**
     * Loads fixtures
     *
     * @return RecreateDevDatabaseCommand
     */
    private function _loadFixtures()
    {
        $command = new ImportFixturesCommand();
        $command->setType('dev');
        $command->run();

        return $this;
    }

    private function _cloneDb()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/dev.sql',
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'name']),
                FILES_ROOT
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/dev.sql',
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'name']) . 'Admin',
                FILES_ROOT
            )
        );

        return $this;
    }
}
