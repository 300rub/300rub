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
     * @return RecreateSeleniumDatabaseCommand
     */
    private function _recreateDbs()
    {
        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->createDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $dbObject->getReadDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
                true
            )
            ->createDb(
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $dbObject->getWriteDbName(
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
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->importDb(
                $config->getValue(['db', 'selenium', 'host']),
                $dbObject->getWriteDbName(
                    $config->getValue(['db', 'selenium', 'name'])
                ),
                Db::SOURCE_PATH
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
        $dbObject = App::getInstance()->getDb();

        $dbName = $config->getValue(['db', 'selenium', 'name']);
        $dbHost = $config->getValue(['db', 'selenium', 'host']);
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
