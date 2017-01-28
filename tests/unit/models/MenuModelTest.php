<?php

namespace testS\tests\unit\models;

use testS\models\MenuModel;

/**
 * Tests for the model MenuModel
 *
 * @package testS\tests\unit\models
 */
class MenuModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getNewModel()
    {
        return new MenuModel();
    }
}