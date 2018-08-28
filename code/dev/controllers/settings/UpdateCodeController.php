<?php

namespace ss\controllers\settings;

use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\settings\SettingsModel;

/**
 * Updates code
 */
class UpdateCodeController extends AbstractController
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
                'type'  => [self::TYPE_STRING, self::NOT_EMPTY],
                'value' => [self::TYPE_STRING],
            ]
        );

        $settingsModel = $this->_getSettingsModel();

        $settingsModel
            ->set(['value' => $this->get('value')])
            ->save();

        return $this->getSimpleSuccessResult();
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
