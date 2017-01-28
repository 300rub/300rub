<?php

namespace testS\tests\unit\models;

use testS\models\UserModel;

/**
 * Tests for the model UserModel
 *
 * @package testS\tests\unit\models
 */
class UserModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserModel
     */
    protected function getNewModel()
    {
        return new UserModel();
    }
}