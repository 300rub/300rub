<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
use ss\commands\db\_abstract\AbstractDbCommand;

/**
 * Recreates Phpunit databases
 */
class RecreatePhpunitDatabaseCommand extends AbstractDbCommand
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
            ->_recreateDb()
            ->_importSourceDb()
            ->_loadFixtures()
            ->_exportDb();
    }

    /**
     * Recreates DBs
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _recreateDb()
    {
        $config = App::getInstance()->getConfig();

        App::getInstance()->getDb()
            ->createDb(
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'password']),
                App::getInstance()->getDb()->getWriteDbName(
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
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->importDb(
                $config->getValue(['db', 'phpunit', 'host']),
                $dbObject->getWriteDbName(
                    $config->getValue(['db', 'phpunit', 'name'])
                ),
                Db::SOURCE_PATH
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
     * Exports DB
     *
     * @return RecreatePhpunitDatabaseCommand
     */
    private function _exportDb()
    {
        $config = App::getInstance()->getConfig();

        App::getInstance()->getDb()->exportDb(
            $config->getValue(['db', 'phpunit', 'host']),
            App::getInstance()->getDb()->getWriteDbName(
                $config->getValue(['db', 'phpunit', 'name'])
            )
        );

        return $this;
    }
}
