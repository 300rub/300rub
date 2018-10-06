<?php

namespace ss\controllers\release;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserEventModel;

/**
 * Gets release short info
 */
class GetShortInfoController extends AbstractController
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

        $language = App::getInstance()->getLanguage();

        $moreLabel = sprintf(
            '%s (%s)',
            $language->getMessage('release', 'moreInfoLabel'),
            UserEventModel::model()->getCount()
        );

        return [
            'title'         => $language->getMessage('release', 'panelTitle'),
            'description'   => $language->getMessage('release', 'panelDescription'),
            'labels'        => [
                'moreInfo' => $moreLabel,
                'button'   => $language->getMessage('release', 'applyButton'),
            ],
        ];
    }
}
