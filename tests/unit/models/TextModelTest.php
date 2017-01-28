<?php

namespace testS\tests\unit\models;

use testS\models\TextModel;

/**
 * Tests for the model TextModel
 *
 * @package testS\tests\unit\models
 */
class TextModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
    }
}