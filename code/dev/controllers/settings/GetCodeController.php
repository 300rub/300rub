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

        $this->checkData(
            [
                'type' => [self::TYPE_STRING, self::NOT_EMPTY],
            ]
        );

        $settingsModel = $this->_getSettingsModel();
        $language = App::getInstance()->getLanguage();

        return [
            'title' => $settingsModel->getTypeValue(),
            'type'  => $this->get('type'),
            'forms' => [
                'value'       => [
                    'name'  => 'value',
                    'value' => $settingsModel->get('value'),
                    'validation'
                           => $settingsModel->getValidationRulesForField('value'),
                ],
            ],
            'labels' => [
                'button' => $language->getMessage('common', 'saveAndReload'),
            ],
        ];
    }

    /**
     * Gets SettingsModel
     *
     * @return SettingsModel
     */
    private function _getSettingsModel()
    {
        $type = $this->get('type');

        $settingModel = SettingsModel::model()->byType($type)->find();
        if ($settingModel === null) {
            $settingModel = SettingsModel::model()
                ->set(['type' => $this->get('type')])
                ->save();
        }

        return $settingModel;
    }
}
