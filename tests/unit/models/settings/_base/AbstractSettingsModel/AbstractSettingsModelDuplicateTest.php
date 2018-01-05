<?php

namespace testS\tests\unit\models\settings\_base\AbstractSettingsModel;

use testS\models\settings\SettingsModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model SettingsModel
 */
class AbstractSettingsModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'type'  => 'icon',
                'value' => 'icon_file_path.ico'
            ],
            [
                'value' => ['required']
            ]
        );
    }
}
