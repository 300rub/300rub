<?php

namespace ss\controllers\release;

use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserEventModel;

/**
 * Checks if a release is available
 */
class GetReadyController extends AbstractController
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

        $isReadyToRelease = false;
        $userEventsCount = UserEventModel::model()->getCount();
        if ($userEventsCount > 0) {
            $isReadyToRelease = true;
        }

        return [
            'isReadyToRelease' => $isReadyToRelease
        ];
    }
}
