<?php

namespace ss\tests\unit\models\user\_base\AbstractUserModel;

use ss\models\user\UserModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
