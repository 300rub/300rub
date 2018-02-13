<?php

namespace ss\commands;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Create dumps command
 */
class CreateSqlDumpsCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject->setSystemPdo();

        $sites = $dbObject->fetchAll('SELECT * ' . 'FROM `sites`');

        foreach ($sites as $site) {
            $dbObject->setPdo(
                $site['dbHost'],
                $site['dbUser'],
                $site['dbPassword'],
                $site['dbName']
            );

            exec(
                sprintf(
                    'mysqldump -u %s -p%s -h %s %s | gzip -c > %s/%s.sql.gz',
                    $site['dbUser'],
                    $site['dbPassword'],
                    $site['dbHost'],
                    $site['dbName'],
                    __DIR__ . '/../tmp/backups',
                    $site['dbName']
                )
            );
        }
    }
}
