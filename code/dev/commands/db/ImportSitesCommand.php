<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\application\exceptions\MigrationException;

/**
 * Rollback Sql dumps command
 */
class ImportSitesCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     *
     * @throws MigrationException
     */
    public function run()
    {
        $this->checkIsDev();

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

            $file = FILES_ROOT . '/backups/' . $site['dbName'] . '.sql';
            if (file_exists($file) === false) {
                throw new MigrationException(
                    'Unable to find the dump file for DB: {db}',
                    [
                        'db' => $site['dbName']
                    ]
                );
            }

            exec(
                sprintf(
                    'export MYSQL_PWD=%s; ' .
                    'mysql -u %s -h %s %s < %s',
                    $site['password'],
                    $site['user'],
                    $site['host'],
                    $site['name'],
                    $file
                )
            );
        }
    }
}
