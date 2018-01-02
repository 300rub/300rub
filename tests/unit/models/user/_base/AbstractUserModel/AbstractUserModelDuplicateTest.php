<?php

namespace testS\tests\unit\models\user\_base\AbstractUserModel;

use testS\models\user\UserModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserModel
 */
class AbstractUserModelDuplicateTest extends AbstractDuplicateModelTest
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

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'login'    => 'login1',
                'password' => $this->generateStringWithLength(40),
                'name'     => 'Name',
                'email'    => 'email@email.com',
            ],
            [
                'login'    => ['required', 'minLength'],
                'password' => ['required', 'minLength'],
                'name'     => ['required'],
                'email'    => ['required', 'email'],
            ]
        );
    }
}
