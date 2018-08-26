<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;

/**
 * Creates a release
 */
class CreateReleaseController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSettingsOperation(
            Operation::SETTINGS_USER_CAN_RELEASE
        );

        $site = App::getInstance()->getSite();
        $dbObject = App::getInstance()->getDb();
        $host = $site->get('dbHost');

        $dbObject->exportDb(
            $host,
            $site->getWriteDbName()
        );

        $dbObject->importDb(
            $host,
            $site->getReadDbName(),
            $dbObject->getBackupPath($site->getWriteDbName())
        );

        return $this->getSimpleSuccessResult();
    }
}
