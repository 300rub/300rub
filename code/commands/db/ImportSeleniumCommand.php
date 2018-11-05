<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Loads test SQL dump command
 */
class ImportSeleniumCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $dbConfig = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'selenium']);

        App::getInstance()->getDb()->importDb(
            $dbConfig['host'],
            App::getInstance()->getDb()->getWriteDbName(
                $dbConfig['name']
            )
        );
    }
}
