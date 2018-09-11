<?php

namespace ss\controllers\settings;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\settings\SettingsModel;
use ss\models\user\UserEventModel;

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

        $this->_writeEvent();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Write an event
     *
     * @return UpdateCodeController
     */
    private function _writeEvent()
    {
        $language = App::getInstance()->getLanguage();

        $eventName = '';
        switch ($this->get('type')) {
            case SettingsModel::CODE_HEADER:
                $eventName = $language->getMessage(
                    'event',
                    'settingsCodeHeader'
                );
                break;
            case SettingsModel::CODE_BODY_TOP:
                $eventName = $language->getMessage(
                    'event',
                    'settingCodeBodyTop'
                );
                break;
            case SettingsModel::CODE_BODY_BOTTOM:
                $eventName = $language->getMessage(
                    'event',
                    'settingsCodeBodyBottom'
                );
                break;
        }

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_SETTINGS,
            UserEventModel::TYPE_EDIT,
            $eventName
        );

        return $this;
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
