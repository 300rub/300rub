<?php

namespace testS\tests\unit\models;

use testS\models\GridModel;

/**
 * Tests for the model GridModel
 *
 * @package testS\tests\unit\models
 */
class GridModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return GridModel
     */
    protected function getNewModel()
    {
        return new GridModel();
    }
}