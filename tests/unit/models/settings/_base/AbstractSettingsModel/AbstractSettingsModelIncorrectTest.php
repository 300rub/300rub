<?php

namespace testS\tests\unit\models\settings\_base\AbstractSettingsModel;

use testS\models\settings\SettingsModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                    'type'  => 'icon',
                    'value' => 'icon_file_path.ico'
                ],
                [
                    'type'  => 'icon',
                    'value' => 'icon_file_path.ico'
                ],
                [
                    'type'  => 'appleTouchIcon57',
                    'value' => 'apple_icon_file_path.png'
                ],
                [
                    'type'  => 'icon',
                    'value' => 'apple_icon_file_path.png'
                ]
            ],
            'incorrect3' => [
                [
                    'type'  => 'icon',
                    'value' => $this->generateStringWithLength(256)
                ],
                [
                    'value' => ['maxLength']
                ],
            ],
        ];
    }
}
