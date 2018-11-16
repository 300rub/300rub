<?php

namespace ss\commands\db;

use ss\application\App;

use ss\application\components\db\Db;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\system\Sites;
use ss\migrations\system\Domains;
use ss\migrations\system\Help;

/**
 * Recreates system databases
 */
class RecreateSystemDatabasesCommand extends AbstractDbCommand
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
        App::getInstance()->getDb()
            ->dropDb(
                $this->_dbHost,
                'sys'
            );

        $databases = App::getInstance()
            ->getDb()
            ->getAllDbNames($this->_dbHost);
        foreach ($databases as $database) {
            if (strpos($database, 'site') !== 0) {
                continue;
            }

            App::getInstance()->getDb()->dropDb(
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

        App::getInstance()->getDb()
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
        $dbObject = App::getInstance()->getDb();

        $dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_SYSTEM);

        $migration = new Sites();
        $migration->execute($migration->generateSqlUp());

        $migration = new Domains();
        $migration->execute($migration->generateSqlUp());

        $dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_HELP);

        $migration = new Help();
        $migration->execute($migration->generateSqlUp());

        return $this;
    }

    /**
     * Loads fixtures
     *
     * @return RecreateSystemDatabasesCommand
     */
    private function _loadFixtures()
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_SYSTEM);

        $command = new ImportFixturesCommand();
        $command->setType(Db::CONFIG_DB_NAME_SYSTEM);
        $command->run();

        $dbObject->setActivePdoKey(Db::CONFIG_DB_NAME_HELP);

        $command = new ImportFixturesCommand();
        $command->setType(Db::CONFIG_DB_NAME_HELP);
        $command->run();

        return $this;
    }
}
