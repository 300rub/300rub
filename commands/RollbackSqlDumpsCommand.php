<?php

namespace ss\commands;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\application\exceptions\MigrationException;

/**
 * Rollback Sql dumps command
 */
class RollbackSqlDumpsCommand extends AbstractCommand
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

            $file = FILES_ROOT . '/backups/' . $site['dbName'] . '.sql.gz';
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
                    'gunzip < %s | mysql -u %s -h %s %s',
                    $site['dbPassword'],
                    $file,
                    $site['dbUser'],
                    $site['dbHost'],
                    $site['dbName']
                )
            );
        }
    }
}
