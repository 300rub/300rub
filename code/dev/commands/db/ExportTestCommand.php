<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Creates test SQL dump command
 */
class ExportTestCommand extends AbstractCommand
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
