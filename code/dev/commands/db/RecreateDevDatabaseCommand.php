<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
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
            ->createDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $this->_dbObject->getReadDbName(
                    $config->getValue(['db', 'dev', 'name'])
                ),
                true
            )
            ->createDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $this->_dbObject->getWriteDbName(
                    $config->getValue(['db', 'dev', 'name'])
                ),
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
                'mysql -u %s -h %s %s < %s',
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $this->_dbObject->getWriteDbName(
                    $config->getValue(['db', 'dev', 'name'])
                ),
                Db::SOURCE_PATH
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

    /**
     * Clones DB
     *
     * @return RecreateDevDatabaseCommand
     */
    private function _cloneDb()
    {
        $config = App::getInstance()->getConfig();

        $dbName = $config->getValue(['db', 'dev', 'name']);
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
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $dbWriteName,
                FILES_ROOT,
                $dbWriteName
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s/backups/%s.sql',
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'host']),
                $dbReadName,
                FILES_ROOT,
                $dbWriteName
            )
        );

        return $this;
    }
}
