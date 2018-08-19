<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreatePhpunitDatabaseCommand extends AbstractDbCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $config = App::getInstance()->getConfig();

        $this->checkConnection();

        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->createNewDb(
                $config->getValue(['db', 'phpunit', 'host']),
                $config->getValue(['db', 'phpunit', 'user']),
                $config->getValue(['db', 'phpunit', 'password']),
                $config->getValue(['db', 'phpunit', 'name']),
                true
            );

        $dbObject->setPdo(
            $config->getValue(['db', 'phpunit', 'host']),
            $config->getValue(['db', 'phpunit', 'user']),
            $config->getValue(['db', 'phpunit', 'password']),
            $config->getValue(['db', 'phpunit', 'name'])
        );

        $migration = new M160302000000Migrations();
        $migration->apply();
    }
}
