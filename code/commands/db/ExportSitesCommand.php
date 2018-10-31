<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
use ss\commands\_abstract\AbstractCommand;
use ss\models\system\SiteModel;

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

        $dbObject->setActivePdoKey(
            Db::CONFIG_DB_NAME_SYSTEM
        );

        $sites = SiteModel::model()->findAll(true);

        foreach ($sites as $site) {
            $dbObject
                ->exportDb(
                    $site['t_dbHost'],
                    $dbObject->getWriteDbName($site['t_dbName'])
                )
                ->exportDb(
                    $site['t_dbHost'],
                    $dbObject->getReadDbName($site['t_dbName'])
                );
        }
    }
}
