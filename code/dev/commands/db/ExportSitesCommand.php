<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Create dumps command
 */
class ExportSitesCommand extends AbstractCommand
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
                    'export MYSQL_PWD=%s; ' .
                    'mysqldump -u %s -h %s %s > %s/backups/%s.sql',
                    $site['dbPassword'],
                    $site['dbUser'],
                    $site['dbHost'],
                    $site['dbName'],
                    FILES_ROOT,
                    $site['dbName']
                )
            );
        }
    }
}
