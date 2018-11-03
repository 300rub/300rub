<?php

namespace ss\tests\phpunit\models\settings\_base\AbstractSettingsModel;

use ss\models\settings\SettingsModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
                'type'  => 'ICON',
                'value' => 'icon_file_path.ico'
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
