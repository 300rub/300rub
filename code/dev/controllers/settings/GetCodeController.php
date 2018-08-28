<?php

namespace ss\controllers\settings;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\settings\SettingsModel;

/**
 * Gets code
 */
class GetCodeController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSettingsOperation(
            Operation::SETTINGS_HIDDEN_CODE
        );

        $language = App::getInstance()->getLanguage();

        $settingsTypeList = SettingsModel::model()->getTypeList();

        $list = [
            [
                'type' => SettingsModel::CODE_HEADER,
                'name' => $settingsTypeList[SettingsModel::CODE_HEADER]
            ],
            [
                'type' => SettingsModel::CODE_BODY_TOP,
                'name' => $settingsTypeList[SettingsModel::CODE_BODY_TOP]
            ],
            [
                'type' => SettingsModel::CODE_BODY_BOTTOM,
                'name' => $settingsTypeList[SettingsModel::CODE_BODY_BOTTOM]
            ],
        ];

        return [
            'title'       => $language->getMessage('settings', 'codeListTitle'),
            'list'        => $list
        ];
    }
}
