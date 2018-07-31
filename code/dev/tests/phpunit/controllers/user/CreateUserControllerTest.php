<?php

namespace ss\tests\phpunit\controllers\user;

use ss\application\components\Operation;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateUserController
 */
class CreateUserControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user               User type
     * @param array  $data               Data to send
     * @param bool   $hasException       Exception flag
     * @param array  $expectedErrors     Expected errors
     * @param bool   $isSuccess          Flag of success
     * @param array  $expectedOperations Expected operations
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testCreateUser(
        $user,
        $data,
        $hasException,
        $expectedErrors = null,
        $isSuccess = null,
        $expectedOperations = null
    ) {
        $this->setUser($user);
        $this->sendRequest('user', 'user', $data, 'POST');

        if ($hasException === true) {
            $this->assertError();
            return true;
        }

        $actual = $this->getBody();

        if ($isSuccess !== true) {
            $this->compareExpectedAndActual($expectedErrors, $actual, true);
            return true;
        }

        $this->compareExpectedAndActual(
            [
                'result' => true,
                'users'  => [
                    'title' => 'Users'
                ]
            ],
            $actual
        );

        $model = $this->_getLatestUserModel();

        if ($expectedOperations !== null) {
            $this->compareExpectedAndActual(
                $expectedOperations,
                $model->getOperations(),
                true
            );
        }

        $model->delete();

        return true;
    }

    /**
     * Gets latest user model
     *
     * @return AbstractModel|UserModel
     */
    private function _getLatestUserModel()
    {
        $model = new UserModel();
        $model->latest();

        return $model->find();
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return array_merge(
            $this->_dataProvider1(),
            $this->_dataProvider2(),
            $this->_dataProvider3(),
            $this->_dataProvider4()
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider1()
    {
        $password1 = $this->generateStringWithLength(32);

        return [
            0  => [
                self::TYPE_NO_OPERATIONS_USER,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
            1  => [
                self::TYPE_BLOCKED_USER,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
            2  => [
                self::TYPE_FULL,
                [
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
            3  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
            4  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
            5  => [
                self::TYPE_FULL,
                [
                    'name'       => 'Name',
                    'login'      => 'newLogin',
                    'password'   => $password1,
                    'type'       => UserModel::TYPE_LIMITED,
                    'email'      => 'newEmail@email.com',
                    'operations' => []
                ],
                true
            ],
            6  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                true
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider2()
    {
        $password1 = $this->generateStringWithLength(32);
        $password2 = $this->generateStringWithLength(32);

        return [
            7  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'operations'      => []
                ],
                true
            ],
            8  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password2,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                false,
                [
                    'errors' => [
                        'passwordConfirm' => 'Passwords do not match'
                    ]
                ]
            ],
            9  => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'user',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_LIMITED,
                    'email'           => 'user@email.com',
                    'operations'      => []
                ],
                false,
                [
                    'errors' => [
                        'login' => 'The field value must be unique',
                        'email' => 'The field value must be unique',
                    ]
                ]
            ],
            10 => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_BLOCKED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => []
                ],
                false,
                null,
                true
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider3()
    {
        $password1 = $this->generateStringWithLength(32);

        return [
            11 => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_BLOCKED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => [
                        Operation::TYPE_SECTIONS => [
                            Operation::ALL => [
                                Operation::SECTION_ADD => true,
                                Operation::SECTION_UPDATE => true,
                                'incorrect' => true
                            ],
                            1              => [
                                Operation::SECTION_DESIGN_UPDATE => true,
                                'incorrect' => true
                            ],
                            'incorrect' => true
                        ],
                        Operation::TYPE_BLOCKS   => [
                            BlockModel::TYPE_TEXT => [
                                Operation::ALL => [
                                    Operation::TEXT_ADD => true,
                                    Operation::TEXT_DELETE => true,
                                    'incorrect' => true
                                ],
                                1              => [
                                    Operation::TEXT_DUPLICATE => true,
                                    'incorrect' => true
                                ],
                                'incorrect' => true
                            ],
                            'incorrect' => true
                        ],
                        Operation::TYPE_SETTINGS => [
                            Operation::SETTINGS_ICON => true,
                            Operation::SETTINGS_USER_VIEW => true,
                            'incorrect' => true
                        ],
                        'incorrect' => true
                    ]
                ],
                false,
                null,
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
     * Data provider
     *
     * @return array
     */
    private function _dataProvider4()
    {
        $password1 = $this->generateStringWithLength(32);

        return [
            12 => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_BLOCKED,
                    'email'           => 'newEmail@email.com',
                ],
                true
            ],
            13 => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_BLOCKED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => [
                        Operation::TYPE_SECTIONS => [
                            9999 => [
                                Operation::SECTION_DESIGN_UPDATE => true,
                            ],
                        ],
                    ]
                ],
                true
            ],
            14 => [
                self::TYPE_FULL,
                [
                    'name'            => 'Name',
                    'login'           => 'newLogin',
                    'password'        => $password1,
                    'passwordConfirm' => $password1,
                    'type'            => UserModel::TYPE_BLOCKED,
                    'email'           => 'newEmail@email.com',
                    'operations'      => [
                        Operation::TYPE_BLOCKS => [
                            BlockModel::TYPE_TEXT => [
                                9999 => [
                                    Operation::TEXT_DUPLICATE => true
                                ]
                            ]
                        ]
                    ]
                ],
                true
            ],
        ];
    }
}
