<?php

namespace testS\tests\unit\models;

use testS\models\DesignTextModel;

/**
 * Tests for the model DesignTextModel
 *
 * @package testS\tests\unit\models
 */
class DesignTextModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getNewModel()
    {
        return new DesignTextModel();
    }
}