<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\M160301000000Sites;
use ss\migrations\M160301000010Domains;
use ss\migrations\M160301000020Help;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreateDevDatabasesCommand extends AbstractDbCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $this->checkIsDev();
        $this->checkConnection();

        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();
        $dbHost = $dbObject->getRandomDbHost();

        $dbObject
            ->dropDb(
                $dbHost,
                'sys'
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'name']),
                true
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'name']) . 'Admin',
                true
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'name']),
                true
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'name']),
                true
            );

        $databases = $dbObject->getAllDbNames($dbHost);
        foreach ($databases as $database) {
            if (strpos($database, 'site') !== 0) {
                continue;
            }

            $dbObject->dropDb(
                $dbHost,
                $database
            );
        }

        $dbObject->setSystemPdo();

        $migration = new M160301000000Sites();
        $migration->apply();

        $migration = new M160301000010Domains();
        $migration->apply();

        $dbObject->setPdo(
            $config->getValue(['db', 'help', 'host']),
            $config->getValue(['db', 'help', 'user']),
            $config->getValue(['db', 'help', 'password']),
            $config->getValue(['db', 'help', 'name'])
        );

        $migration = new M160301000020Help();
        $migration->apply();

        $dbObject->setPdo(
            $config->getValue(['db', 'dev', 'host']),
            $config->getValue(['db', 'dev', 'user']),
            $config->getValue(['db', 'dev', 'password']),
            $config->getValue(['db', 'dev', 'name'])
        );

        $migration = new M160302000000Migrations();
        $migration->apply();
    }
}
