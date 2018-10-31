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
        $site = App::getInstance()->getConfig()->getValue(['db', 'selenium']);

        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->importDb(
                $site['host'],
                $dbObject->getWriteDbName(
                    $site['name']
                ),
                $dbObject->getBackupPath(
                    $dbObject->getWriteDbName(
                        $site['name']
                    )
                )
            )
            ->importDb(
                $site['host'],
                $dbObject->getReadDbName(
                    $site['name']
                ),
                $dbObject->getBackupPath(
                    $dbObject->getReadDbName(
                        $site['name']
                    )
                )
            );
    }
}
