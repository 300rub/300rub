<?php

namespace ss\tests\unit\models\user\_base\AbstractUserModel;

use ss\models\user\UserModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserModel
 */
class AbstractUserModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'login'    => 'a',
                    'password' => 'b',
                    'name'     => 'Name',
                    'email'    => 'email@email.com',
                ],
                [
                    'login'    => ['minLength'],
                    'password' => ['minLength'],
                ],
            ],
            'incorrect2' => [
                [
                    'login'    => $this->generateStringWithLength(51),
                    'password' => $this->generateStringWithLength(41),
                    'name'     => $this->generateStringWithLength(101),
                    'email'    => 'email',
                ],
                [
                    'login'    => ['maxLength'],
                    'password' => ['maxLength'],
                    'name'     => ['maxLength'],
                    'email'    => ['email'],
                ],
            ],
            'incorrect3' => [
                [
                    'login'    => 'owner',
                    'password' => $this->generateStringWithLength(40),
                    'name'     => 'Name',
                    'email'    => 'user@email.com',
                ],
                [
                    'login' => ['unique'],
                    'email' => ['unique'],
                ],
            ],
            'incorrect4' => [
                [
                    'login'    => 'login 3',
                    'password' => $this->generateStringWithLength(40),
                    'name'     => 'Name',
                    'email'    => 'email@email.com',
                ],
                [
                    'login' => ['latinDigitUnderscoreHyphen'],
                ],
            ],
            'incorrect5' => [
                [
                    'login'    => 'login1',
                    'password' => $this->generateStringWithLength(40),
                    'name'     => 'Name',
                    'type'     => 1,
                    'email'    => 'email@email.com',
                ],
                [
                    'type' => 0,
                ],
                [
                    'type' => 1,
                ],
                [
                    'type' => 0,
                ],
            ]
        ];
    }
}
