<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Creates test SQL dump command
 */
class ExportSeleniumCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $site = App::getInstance()->getConfig()->getValue(['db', 'selenium']);

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s/backups/selenium.sql',
                $site['password'],
                $site['user'],
                $site['host'],
                $site['name'],
                FILES_ROOT
            )
        );
    }
}
