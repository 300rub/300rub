<?php

namespace testS\tests\unit\models;

use testS\models\UserSectionModel;

/**
 * Tests for the model UserSectionModel
 *
 * @package testS\tests\unit\models
 */
class UserSectionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionModel
     */
    protected function getNewModel()
    {
        return new UserSectionModel();
    }
}