<?php

namespace testS\tests\unit\models;

use testS\models\SettingModel;

/**
 * Tests for the model SettingModel
 *
 * @package testS\tests\unit\models
 */
class SettingModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SettingModel
     */
    protected function getNewModel()
    {
        return new SettingModel();
    }
}