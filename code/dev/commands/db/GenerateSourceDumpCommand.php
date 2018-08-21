<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\Db;
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
        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();

        $siteName = 'source';

        $dbHost = $dbObject->getRandomDbHost();
        $dbUser = $config->getValue(['db', $siteName, 'user']);
        $dbPassword = $config->getValue(['db', $siteName, 'password']);
        $dbName = $config->getValue(['db', $siteName, 'name']);

        $dbObject->createNewDb(
            $dbHost,
            $dbUser,
            $dbPassword,
            $dbName,
            true
        );

        $dbObject->setConnection(
            Db::CONNECTION_TYPE_GUEST,
            $dbHost,
            $dbUser,
            $dbPassword,
            $dbName,
            true
        );

        $dbObject->setCurrentConnection(Db::CONNECTION_TYPE_GUEST);

        $migration = new M160302000000Migrations();
        $migration->apply();

        $migrateCommand = new MigrateCommand();
        $migrateCommand
            ->setSites([$siteName])
            ->applyMigration();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s',
                $dbPassword,
                $dbUser,
                $dbHost,
                $dbName,
                Db::SOURCE_PATH
            )
        );
    }
}
