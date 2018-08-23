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

        $dbObject->setSystemConnection();

        $sites = $dbObject->fetchAll('SELECT * ' . 'FROM `sites`');

        foreach ($sites as $site) {
            $dbObject->setConnection(
                Db::CONNECTION_TYPE_GUEST,
                $site['dbHost'],
                $site['dbUser'],
                $site['dbPassword'],
                $site['dbName'],
                true
            );

            $dbObject->setCurrentConnection(Db::CONNECTION_TYPE_GUEST);

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

            $adminDbName = $dbObject->getAdminDbName( $site['dbName']);

            $dbObject->setConnection(
                Db::CONNECTION_TYPE_GUEST,
                $site['dbHost'],
                $site['dbUser'],
                $site['dbPassword'],
                $adminDbName,
                true
            );

            $dbObject->setCurrentConnection(Db::CONNECTION_TYPE_GUEST);

            exec(
                sprintf(
                    'export MYSQL_PWD=%s; ' .
                    'mysqldump -u %s -h %s %s > %s/backups/%s.sql',
                    $site['dbPassword'],
                    $site['dbUser'],
                    $site['dbHost'],
                    $adminDbName,
                    FILES_ROOT,
                    $adminDbName
                )
            );
        }
    }
}
