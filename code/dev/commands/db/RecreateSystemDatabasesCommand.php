<?php

namespace ss\commands\db;

use ss\application\App;

use ss\application\components\db\Db;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\M160301000000Sites;
use ss\migrations\M160301000010Domains;
use ss\migrations\M160301000020Help;

/**
 * Recreates system databases
 */
class RecreateSystemDatabasesCommand extends AbstractDbCommand
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
            ->_dropExtraDbs()
            ->_recreateDbs()
            ->_applyMigrations()
            ->_loadFixtures();
    }

    /**
     * Drops extra DBs
     *
     * @return RecreateSystemDatabasesCommand
     */
    private function _dropExtraDbs()
    {
        $this->_dbObject
            ->dropDb(
                $this->_dbHost,
                'sys'
            );

        $databases = $this->_dbObject->getAllDbNames($this->_dbHost);
        foreach ($databases as $database) {
            if (strpos($database, 'site') !== 0) {
                continue;
            }

            $this->_dbObject->dropDb(
                $this->_dbHost,
                $database
            );
        }

        return $this;
    }

    /**
     * Recreates DBs
     *
     * @return RecreateSystemDatabasesCommand
     */
    private function _recreateDbs()
    {
        $config = App::getInstance()->getConfig();

        $this->_dbObject
            ->createDb(
                $this->_dbHost,
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'name']),
                true
            )
            ->createDb(
                $this->_dbHost,
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'name']),
                true
            );

        return $this;
    }

    /**
     * Applies migrations
     *
     * @return RecreateSystemDatabasesCommand
     */
    private function _applyMigrations()
    {
        $this->_dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_SYSTEM);

        $migration = new M160301000000Sites();
        $migration->apply();

        $migration = new M160301000010Domains();
        $migration->apply();

        $this->_dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_HELP);

        $migration = new M160301000020Help();
        $migration->apply();

        return $this;
    }

    /**
     * Loads fixtures
     *
     * @return RecreateSystemDatabasesCommand
     */
    private function _loadFixtures()
    {
        $command = new ImportFixturesCommand();
        $command->setType(Db::CONFIG_DB_NAME_SYSTEM);
        $command->run();

        $command = new ImportFixturesCommand();
        $command->setType(Db::CONFIG_DB_NAME_HELP);
        $command->run();

        return $this;
    }
}
