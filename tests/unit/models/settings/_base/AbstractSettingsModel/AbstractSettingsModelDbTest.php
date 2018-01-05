<?php

namespace testS\tests\unit\models\settings\_base\AbstractSettingsModel;

use testS\models\settings\SettingsModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
