<?php

namespace testS\tests\unit\models;

use testS\models\UserBlockModel;

/**
 * Tests for the model UserBlockModel
 *
 * @package testS\tests\unit\models
 */
class UserBlockModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockModel
     */
    protected function getNewModel()
    {
        return new UserBlockModel();
    }
}