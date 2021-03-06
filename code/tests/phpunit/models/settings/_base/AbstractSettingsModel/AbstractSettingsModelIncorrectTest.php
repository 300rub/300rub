<?php

namespace ss\tests\phpunit\models\settings\_base\AbstractSettingsModel;

use ss\models\settings\SettingsModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model SettingsModel
 */
class AbstractSettingsModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return SettingsModel
     */
    protected function getNewModel()
    {
        return new SettingsModel();
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'type'  => 'incorrect',
                    'value' => 'value'
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            'incorrect2' => [
                [
                    'type'  => 'ICON',
                    'value' => 'icon_file_path.ico'
                ],
                [
                    'type'  => 'ICON',
                    'value' => 'icon_file_path.ico'
                ],
                [
                    'type'  => 'appleTouchIcon57',
                    'value' => 'apple_icon_file_path.png'
                ],
                [
                    'type'  => 'ICON',
                    'value' => 'apple_icon_file_path.png'
                ]
            ],
        ];
    }
}
