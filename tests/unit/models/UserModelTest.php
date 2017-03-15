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

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
            "empty2" => [
                [
                    "login"    => "",
                    "password" => "",
                    "isOwner"  => "",
                    "name"     => "",
                    "email"    => "",
                ],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
            "empty3" => [
                [
                    "login"    => $this->generateStringWithLength(10),
                    "password" => $this->generateStringWithLength(40),
                    "name"     => $this->generateStringWithLength(10),
                    "email"    => "",
                ],
                [
                    "email" => ["required", "email"],
                ],
            ],
            "empty4" => [
                [
                    "login"    => null,
                    "password" => null,
                    "isOwner"  => null,
                    "name"     => null,
                    "email"    => null,
                ],
                [
                    "login"    => ["required", "min"],
                    "password" => ["required", "min"],
                    "name"     => ["required"],
                    "email"    => ["required", "email"],
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        $password1 = $this->generateStringWithLength(40);
        $password2 = $this->generateStringWithLength(40);

        return [
            "correct1" => [
                [
                    "login"    => "login1",
                    "password" => $password1,
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login"    => "login1",
                    "password" => $password1,
                    "isOwner"  => false,
                    "name"     => "Name",
                    "email"    => "email@email.com",
                ],
                [
                    "login"    => "login2",
                    "password" => $password2,
                    "name"     => "Name 2",
                    "email"    => "email2@email.com",
                ],
                [
                    "login"    => "login2",
                    "password" => $password2,
                    "isOwner"  => false,
                    "name"     => "Name 2",
                    "email"    => "email2@email.com",
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}