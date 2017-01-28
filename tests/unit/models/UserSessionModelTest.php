<?php

namespace testS\tests\unit\models;

use testS\models\UserSessionModel;

/**
 * Tests for the model UserSessionModel
 *
 * @package testS\tests\unit\models
 */
class UserSessionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSessionModel
     */
    protected function getNewModel()
    {
        return new UserSessionModel();
    }
}