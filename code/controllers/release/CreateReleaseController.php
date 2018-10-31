<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\application\components\db\Db;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserEventModel;

/**
 * Creates a release
 */
class CreateReleaseController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->checkSettingsOperation(
            Operation::SETTINGS_USER_CAN_RELEASE
        );

        $site = App::getInstance()->getSite();
        $dbObject = App::getInstance()->getDb();
        $host = $site->get('dbHost');

        $dbObject
            ->beginTransaction(Db::CONFIG_DB_NAME_SYSTEM)
            ->beginTransaction($site->getWriteDbName());

        try {
            $dbObject->exportDb(
                $host,
                $site->getWriteDbName()
            );

            $dbObject->importDb(
                $host,
                $site->getReadDbName(),
                $dbObject->getBackupPath($site->getWriteDbName())
            );

            $dbObject->setActivePdoKey(
                Db::CONFIG_DB_NAME_SYSTEM
            );
            $site
                ->set(['version' => ($site->get('version') + 1)])
                ->save();

            $dbObject->setActivePdoKey(
                $site->getWriteDbName()
            );
            UserEventModel::model()->delete('id > 0');

            $site->clearMemcached();

            $dbObject->commitAll();
        } catch (\Exception $e) {
            $dbObject->rollBackAll();
            throw $e;
        }

        return $this->getSimpleSuccessResult();
    }
}
