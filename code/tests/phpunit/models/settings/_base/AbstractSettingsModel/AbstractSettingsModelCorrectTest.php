<?php

namespace ss\tests\phpunit\models\settings\_base\AbstractSettingsModel;

use ss\models\settings\SettingsModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
                    'type'  => 'ICON',
                    'value' => 'file_path.ico'
                ],
                [
                    'type'  => 'ICON',
                    'value' => 'file_path.ico'
                ],
                [
                    'value' => 'new_file_path.ico'
                ],
                [
                    'type'  => 'ICON',
                    'value' => 'new_file_path.ico'
                ],
            ]
        ];
    }
}
