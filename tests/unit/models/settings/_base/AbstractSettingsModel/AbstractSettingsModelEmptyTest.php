<?php

namespace ss\tests\unit\models\settings\_base\AbstractSettingsModel;

use ss\models\settings\SettingsModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model SettingsModel
 */
class AbstractSettingsModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            'empty2' => [
                [
                    'type'  => '',
                    'value' => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            'empty3' => [
                [
                    'type'  => null,
                    'value' => null,
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            'empty4' => [
                [
                    'value' => '111',
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            'empty5' => [
                [
                    'type' => 'icon',
                ],
                [
                    'value' => ['required']
                ],
            ],
            'empty6' => [
                [
                    'type'  => 'icon',
                    'value' => '',
                ],
                [
                    'value' => ['required']
                ],
            ],
        ];
    }
}
