<?php

namespace ss\commands;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Creates test SQL dump command
 */
class CreateTestSqlDumpCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $site = App::getInstance()->getConfig()->getValue(['db', 'dev']);

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s | gzip -c > %s/test.sql.gz',
                $site['password'],
                $site['user'],
                $site['host'],
                $site['name'],
                FILES_ROOT . '/backups'
            )
        );
    }
}
