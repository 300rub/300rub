<?php

namespace testS\tests\unit\controllers;

use testS\application\App;
use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\UserModel;
use testS\models\UserSessionModel;

/**
 * Tests for the controller UserController
 *
 * @package testS\tests\unit\controllers
 */
class UserControllerTest extends AbstractControllerTest
{


    /**
     * Test for method updateUser
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasException
     * @param array  $expectedErrors
     * @param bool   $isSuccess
     * @param array  $expectedOperations
     *
     * @dataProvider dataProviderForTestUpdateUser
     *
     * @return bool
     */
    public function testUpdateUser(
        $user,
        $data,
        $hasException,
        $expectedErrors = null,
        $isSuccess = false,
        $expectedOperations = null
    )
    {
        $this->setUser($user);

        $model = null;
        if (array_key_exists("id", $data)
            && $data["id"] === "new"
        ) {
            $model = new UserModel();
            $model->set(
                [
                    "name"     => "Name",
                    "login"    => "newLogin",
                    "password" => UserModel::getPasswordHash("pass", true),
                    "type"     => UserModel::TYPE_LIMITED,
                    "email"    => "newEmail@email.com",
                ]
            );
            $model->save();

            $model->addOperations(
                [
                    Operation::TYPE_SECTIONS => [
                        Operation::ALL => [
                            Operation::SECTION_DESIGN_UPDATE,
                            Operation::SECTION_DUPLICATE,
                        ],
                    ],
                ]
            );

            $data["id"] = $model->getId();
        }

        $this->sendRequest("user", "user", $data, "PUT");

        if ($hasException === true) {
            if ($model !== null) {
                $model->delete();
            }

            $this->assertError();
            return true;
        }

        $actual = $this->getBody();

        if ($isSuccess === true) {
            $this->compareExpectedAndActual(
                [
                    "result" => true
                ],
                $actual
            );

            $model = (new UserModel())->byId($model->getId())->find();

            if ($expectedOperations !== null) {
                $this->compareExpectedAndActual($expectedOperations, $model->getOperations(), true);
            }
        } else {
            $this->compareExpectedAndActual($expectedErrors, $actual, true);
        }

        if ($model !== null) {
            $model->delete();
        }

        return true;
    }

    /**
     * Data provider for testUpdateUser
     *
     * @return array
     */
    public function dataProviderForTestUpdateUser()
    {
        $password1 = $this->generateStringWithLength(32);
        $password2 = $this->generateStringWithLength(32);

        return [
            0  => [
                self::TYPE_NO_OPERATIONS_USER,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            1  => [
                self::TYPE_BLOCKED_USER,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            2  => [
                self::TYPE_FULL,
                [
                    "id"               => 1,
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            3  => [
                self::TYPE_FULL,
                [
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            4  => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            5  => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            6  => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            7  => [
                self::TYPE_FULL,
                [
                    "id"              => "new",
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            8 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password2,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                false,
                [
                    "errors" => [
                        "passwordConfirm" => "Passwords do not match"
                    ]
                ]
            ],
            9 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "user",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "user@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                false,
                [
                    "errors" => [
                        "login" => "The field value must be unique",
                        "email" => "The field value must be unique",
                    ]
                ]
            ],
            10 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => false,
                    "operations"       => []
                ],
                false,
                [],
                true,
            ],
            11 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => "incorrect",
                    "operations"       => []
                ],
                true
            ],
            12 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => [
                        Operation::TYPE_SECTIONS => [
                            Operation::ALL => [
                                Operation::SECTION_ADD => true,
                                Operation::SECTION_UPDATE => true,
                                "incorrect" => true
                            ],
                            1              => [
                                Operation::SECTION_DESIGN_UPDATE => true,
                                "incorrect" => true
                            ],
                            "incorrect" => true
                        ],
                        Operation::TYPE_BLOCKS   => [
                            BlockModel::TYPE_TEXT => [
                                Operation::ALL => [
                                    Operation::TEXT_ADD => true,
                                    Operation::TEXT_DELETE => true,
                                    "incorrect" => true
                                ],
                                1              => [
                                    Operation::TEXT_DUPLICATE => true,
                                    "incorrect" => true
                                ],
                                "incorrect" => true
                            ],
                            "incorrect" => true
                        ],
                        Operation::TYPE_SETTINGS => [
                            Operation::SETTINGS_ICON => true,
                            Operation::SETTINGS_USER_VIEW => true,
                            "incorrect" => true
                        ],
                        "incorrect" => true
                    ]
                ],
                false,
                [],
                true,
                [
                    Operation::TYPE_SECTIONS => [
                        Operation::ALL => [
                            Operation::SECTION_ADD,
                            Operation::SECTION_UPDATE
                        ],
                        1              => [
                            Operation::SECTION_DESIGN_UPDATE
                        ]
                    ],
                    Operation::TYPE_BLOCKS   => [
                        BlockModel::TYPE_TEXT => [
                            Operation::ALL => [
                                Operation::TEXT_ADD,
                                Operation::TEXT_DELETE,
                            ],
                            1              => [
                                Operation::TEXT_DUPLICATE
                            ]
                        ]
                    ],
                    Operation::TYPE_SETTINGS => [
                        Operation::SETTINGS_ICON,
                        Operation::SETTINGS_USER_VIEW,
                    ],
                ]
            ],
        ];
    }

    /**
     * Test for user deleting
     *
     * @param string $user
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestDeleteUser
     */
    public function testDeleteUser($user, $hasError = false)
    {
        $newUser = new UserModel();
        $newUser->set(
            [
                "login"    => $this->generateStringWithLength(7),
                "password" => $this->generateStringWithLength(40),
                "type"     => UserModel::TYPE_FULL,
                "name"     => $this->generateStringWithLength(10),
                "email"    => $this->generateStringWithLength(7) . "@email.com",
            ]
        );
        $newUser->save();

        $newUser = (new UserModel())->byId($newUser->getId())->find();
        $this->assertNotNull($newUser);

        $this->setUser($user);
        $this->sendRequest("user", "user", ["id" => $newUser->getId()], "DELETE");

        if ($hasError === true) {
            $newUser->delete();
            $this->assertError();
        } else {
            $this->assertSame(
                [
                    "result" => true
                ],
                $this->getBody()
            );
        }

        $newUser = (new UserModel())->byId($newUser->getId())->find();
        $this->assertNull($newUser);

        // Unable to remove owner
        $this->sendRequest("user", "user", ["id" => 1], "DELETE");
        $this->assertError();
    }

    /**
     * Data provider for testDeleteUser
     *
     * @return array
     */
    public function dataProviderForTestDeleteUser()
    {
        return [
            [self::TYPE_FULL],
            [self::TYPE_OWNER],
            [self::TYPE_LIMITED, true],
            [self::TYPE_BLOCKED_USER, true],
        ];
    }
}