<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\M160302000000Migrations;

/**
 * Generates Source SQL script
 */
class GenerateSourceDumpCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        try {
            var_dump(1111);

            $config = App::getInstance()->getConfig();
            $dbObject = App::getInstance()->getDb();

            $siteName = 'source';

            $dbHost = $dbObject->getRandomDbHost();
            $dbUser = $config->getValue(['db', $siteName, 'user']);
            $dbPassword = $config->getValue(['db', $siteName, 'password']);
            $dbName = $config->getValue(['db', $siteName, 'name']);

            $dbObject->createDb(
                $dbHost,
                $dbUser,
                $dbPassword,
                $dbName,
                true
            );

            $dbObject->addPdo(
                $dbHost,
                $dbUser,
                $dbPassword,
                $dbName
            );

            $dbObject->setActivePdoKey($dbName);

            $migration = new M160302000000Migrations();
            $migration->apply();

            $migrateCommand = new MigrateCommand();
            $migrateCommand
                ->setSites([$siteName])
                ->applyMigration();

            $dbObject->exportDb($dbHost, $dbName, Db::SOURCE_PATH);

            var_dump(222);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
