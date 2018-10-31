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

        $this->_dbHost = App::getInstance()
            ->getDb()
            ->getRandomDbHost();

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
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->createDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $dbObject->getReadDbName(
                    $config->getValue(['db', 'dev', 'name'])
                ),
                true
            )
            ->createDb(
                $config->getValue(['db', 'dev', 'host']),
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $dbObject->getWriteDbName(
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
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->importDb(
                $config->getValue(['db', 'dev', 'host']),
                $dbObject->getWriteDbName(
                    $config->getValue(['db', 'dev', 'name'])
                ),
                Db::SOURCE_PATH
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
        $dbObject = App::getInstance()->getDb();

        $dbName = $config->getValue(['db', 'dev', 'name']);
        $dbHost = $config->getValue(['db', 'dev', 'host']);
        $dbWriteName = $dbObject->getWriteDbName(
            $dbName
        );
        $dbReadName = $dbObject->getReadDbName(
            $dbName
        );

        $dbObject
            ->exportDb($dbHost, $dbWriteName)
            ->importDb(
                $dbHost,
                $dbReadName,
                $dbObject->getBackupPath($dbWriteName)
            );

        return $this;
    }
}
