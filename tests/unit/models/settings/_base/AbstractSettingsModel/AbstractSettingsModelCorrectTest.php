<?php

namespace testS\tests\unit\models\settings\_base\AbstractSettingsModel;

use testS\models\settings\SettingsModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model SettingsModel
 */
class AbstractSettingsModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'type'  => 'icon',
                    'value' => 'file_path.ico'
                ],
                [
                    'type'  => 'icon',
                    'value' => 'file_path.ico'
                ],
                [
                    'value' => 'new_file_path.ico'
                ],
                [
                    'type'  => 'icon',
                    'value' => 'new_file_path.ico'
                ],
            ]
        ];
    }
}
