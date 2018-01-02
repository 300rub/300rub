<?php

namespace testS\tests\unit\models\user\_base\AbstractUserModel;

use testS\models\user\UserModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserModel
 */
class AbstractUserModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        $password1 = $this->generateStringWithLength(40);
        $password2 = $this->generateStringWithLength(40);

        return [
            'correct1' => [
                [
                    'login'    => 'login1',
                    'password' => $password1,
                    'type'     => 3,
                    'name'     => 'Name',
                    'email'    => 'email@email.com',
                ],
                [
                    'login'    => 'login1',
                    'password' => $password1,
                    'type'     => 3,
                    'name'     => 'Name',
                    'email'    => 'email@email.com',
                ],
                [
                    'login'    => 'login2',
                    'password' => $password2,
                    'type'     => 2,
                    'name'     => 'Name 2',
                    'email'    => 'email2@email.com',
                ],
                [
                    'login'    => 'login2',
                    'password' => $password2,
                    'type'     => 2,
                    'name'     => 'Name 2',
                    'email'    => 'email2@email.com',
                ],
            ]
        ];
    }
}
