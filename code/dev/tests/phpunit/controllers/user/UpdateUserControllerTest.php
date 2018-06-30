<?php

namespace ss\tests\unit\controllers\user;

use ss\application\components\Operation;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateUserController
 */
class UpdateUserControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user               User type
     * @param array  $data               Data to send
     * @param bool   $hasException       Exception flag
     * @param array  $expectedErrors     Expected errors
     * @param bool   $isSuccess          Success flag
     * @param array  $expectedOperations Expected operations
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun(
        $user,
        $data,
        $hasException,
        $expectedErrors = null,
        $isSuccess = null,
        $expectedOperations = null
    ) {
        $this->setUser($user);

        $model = null;
        if (array_key_exists('id', $data) === true
            && $data['id'] === 'new'
        ) {
            $model = new UserModel();
            $model->set(
                [
                    'name'     => 'Name',
                    'login'    => 'newLogin',
                    'password' => $model->getPasswordHash('pass', true),
                    'type'     => UserModel::TYPE_LIMITED,
                    'email'    => 'newEmail@email.com',
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

            $data['id'] = $model->getId();
        }

        $this->sendRequest('user', 'user', $data, 'PUT');

        if ($hasException === true) {
            if ($model !== null) {
                $model->delete();
            }

            $this->assertError();
            return true;
        }

        $actual = $this->getBody();

        if ($isSuccess !== true) {
            $this->compareExpectedAndActual($expectedErrors, $actual, true);

            if ($model !== null) {
                $model->delete();
            }

            return true;
        }

        $this->compareExpectedAndActual(
            [
                'result' => true
            ],
            $actual
        );

        $model = $this->_getUserModelById($model->getId());

        if ($expectedOperations !== null) {
            $this->compareExpectedAndActual(
                $expectedOperations,
                $model->getOperations(),
                true
            );
        }

        if ($model !== null) {
            $model->delete();
        }

        return true;
    }

    /**
     * Gets model by ID
     *
     * @param integer $modelId Model ID
     *
     * @return AbstractModel|UserModel
     */
    private function _getUserModelById($modelId)
    {
        $model = new UserModel();
        $model->byId($modelId);
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
            $this->_dataProvider3()
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
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            1  => [
                self::TYPE_BLOCKED_USER,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            2  => [
                self::TYPE_FULL,
                [
                    'id'               => 1,
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            3  => [
                self::TYPE_FULL,
                [
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            4  => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            5  => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
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
            6  => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                true
            ],
            7  => [
                self::TYPE_FULL,
                [
                    'id'              => 'new',
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
            8 => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password2,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
                ],
                false,
                [
                    'errors' => [
                        'passwordConfirm' => 'Passwords do not match'
                    ]
                ]
            ],
            9 => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'user',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'user@email.com',
                    'isChangePassword' => true,
                    'operations'       => []
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
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => false,
                    'operations'       => []
                ],
                false,
                [],
                true,
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
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => 'incorrect',
                    'operations'       => []
                ],
                true
            ],
            12 => [
                self::TYPE_FULL,
                [
                    'id'               => 'new',
                    'name'             => 'Name',
                    'login'            => 'newLogin',
                    'password'         => $password1,
                    'passwordConfirm'  => $password1,
                    'type'             => UserModel::TYPE_LIMITED,
                    'email'            => 'newEmail@email.com',
                    'isChangePassword' => true,
                    'operations'       => [
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
}
