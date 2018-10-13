<?php

namespace ss\controllers\settings;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\settings\SettingsModel;

/**
 * Gets a list of codes
 */
class GetCodeListController extends AbstractController
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
        $settingModel = new SettingsModel();

        $list = [
            [
                'type' => SettingsModel::CODE_HEADER,
                'name' => $settingModel->getTypeValue(
                    SettingsModel::CODE_HEADER
                )
            ],
            [
                'type' => SettingsModel::CODE_BODY_TOP,
                'name' => $settingModel->getTypeValue(
                    SettingsModel::CODE_BODY_TOP
                )
            ],
            [
                'type' => SettingsModel::CODE_BODY_BOTTOM,
                'name' => $settingModel->getTypeValue(
                    SettingsModel::CODE_BODY_BOTTOM
                )
            ],
        ];

        return [
            'title'       => $language->getMessage('settings', 'codeListTitle'),
            'description'
                => $language->getMessage('settings', 'codeListDescription'),
            'list'        => $list
        ];
    }
}
