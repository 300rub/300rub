<?php

namespace testS\tests\unit\models\user\_base\AbstractUserModel;

use testS\models\user\UserModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserModel
 */
class AbstractUserModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'login'    => ['required', 'minLength'],
                    'password' => ['required', 'minLength'],
                    'name'     => ['required'],
                    'email'    => ['required', 'email'],
                ],
            ],
            'empty2' => [
                [
                    'login'    => '',
                    'password' => '',
                    'type'     => '',
                    'name'     => '',
                    'email'    => '',
                ],
                [
                    'login'    => ['required', 'minLength'],
                    'password' => ['required', 'minLength'],
                    'name'     => ['required'],
                    'email'    => ['required', 'email'],
                ],
            ],
            'empty3' => [
                [
                    'login'    => $this->generateStringWithLength(10),
                    'password' => $this->generateStringWithLength(40),
                    'name'     => $this->generateStringWithLength(10),
                    'email'    => '',
                ],
                [
                    'email' => ['required', 'email'],
                ],
            ],
            'empty4' => [
                [
                    'login'    => null,
                    'password' => null,
                    'type'     => null,
                    'name'     => null,
                    'email'    => null,
                ],
                [
                    'login'    => ['required', 'minLength'],
                    'password' => ['required', 'minLength'],
                    'name'     => ['required'],
                    'email'    => ['required', 'email'],
                ],
            ],
        ];
    }
}
