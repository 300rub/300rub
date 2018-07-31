<?php

namespace ss\tests\phpunit\models\settings\_base\AbstractSettingsModel;

use ss\models\settings\SettingsModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model SettingsModel
 */
class AbstractSettingsModelDbTest extends AbstractDbModelTest
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
}
