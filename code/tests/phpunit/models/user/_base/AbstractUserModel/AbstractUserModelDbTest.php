<?php

namespace ss\tests\phpunit\models\user\_base\AbstractUserModel;

use ss\models\user\UserModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserModel
 */
class AbstractUserModelDbTest extends AbstractDbModelTest
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
