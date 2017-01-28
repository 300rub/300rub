<?php

namespace testS\tests\unit\models;

use testS\models\FormModel;

/**
 * Tests for the model FormModel
 *
 * @package testS\tests\unit\models
 */
class FormModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
    }
}