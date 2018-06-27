<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Loads test SQL dump command
 */
class ImportTestCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $this->checkIsDev();

        $site = App::getInstance()->getConfig()->getValue(['db', 'test']);

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'gunzip < %s | mysql -u %s -h %s %s',
                $site['password'],
                FILES_ROOT . '/backups/test.sql.gz',
                $site['user'],
                $site['host'],
                $site['name']
            )
        );
    }
}
