<?php

namespace testS\tests\unit\models;

use testS\models\RecordModel;

/**
 * Tests for the model RecordModel
 *
 * @package testS\tests\unit\models
 */
class RecordModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return RecordModel
     */
    protected function getNewModel()
    {
        return new RecordModel();
    }
}