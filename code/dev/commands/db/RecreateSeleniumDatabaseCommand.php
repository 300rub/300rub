<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreateSeleniumDatabaseCommand extends AbstractDbCommand
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
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'name']),
                true
            );

        $dbObject->setPdo(
            $config->getValue(['db', 'selenium', 'host']),
            $config->getValue(['db', 'selenium', 'user']),
            $config->getValue(['db', 'selenium', 'password']),
            $config->getValue(['db', 'selenium', 'name'])
        );

        $migration = new M160302000000Migrations();
        $migration->apply();
    }
}
