<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Creates test SQL dump command
 */
class ExportPhpunitCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $site = App::getInstance()->getConfig()->getValue(['db', 'phpunit']);

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/phpunit.sql',
                $site['password'],
                $site['user'],
                $site['host'],
                $site['name'],
                FILES_ROOT
            )
        );
    }
}
