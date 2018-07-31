<?php

namespace ss\tests\phpunit\controllers\user;

use ss\application\components\Operation;
use ss\models\user\UserModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetUserController
 */
class GetUserControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $userId   User ID
     * @param array  $expected Expected data
     * @param bool   $isError  Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $userId, $expected, $isError = null)
    {
        $this->setUser($user);
        $this->sendRequest('user', 'user', ['id' => $userId]);

        if ($isError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody());
        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return array_merge(
            $this->_dataProviderOwnerGetOwner(),
            $this->_dataProviderAdminGetUser(),
            $this->_dataProviderOwnerAddNewUser(),
            $this->_dataProviderSmall1(),
            $this->_dataProviderSmall2(),
            $this->_dataProviderError()
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderOwnerGetOwner()
    {
        return [
            'ownerGetOwner' => [
                self::TYPE_OWNER,
                1,
                [
                    'id'         => 1,
                    'title'      => 'Edit user',
                    'name'       => [
                        'label'      => 'Name',
                        'value'      => 'Owner',
                        'name'       => 'name',
                        'validation' => [
                            'required' => 'required',
                            'maxLength' => 100,
                        ],
                    ],
                    'login'      => [
                        'label'      => 'Login',
                        'value'      => 'owner',
                        'name'       => 'login',
                        'validation' => [
                            'required'
                                => 'required',
                            'minLength'
                                => 3,
                            'maxLength'
                                => 50,
                            'latinDigitUnderscoreHyphen'
                                => 'latinDigitUnderscoreHyphen'
                        ],
                    ],
                    'email'      => [
                        'label'      => 'Email',
                        'value'      => 'owner@email.com',
                        'name'       => 'email',
                        'validation' => [
                            'required' => 'required',
                            'email'    => 'email',
                        ],
                    ],
                    'type'       => [
                        'label' => 'Type',
                        'value' => UserModel::TYPE_OWNER,
                        'name'  => 'type',
                        'list'  => [
                            [
                                'key'   => 0,
                                'value' => 'Blocked'
                            ],
                            [
                                'key'   => 2,
                                'value' => 'Full'
                            ],
                            [
                                'key'   => 3,
                                'value' => 'Limited'
                            ]
                        ]
                    ],
                    'operations' => [
                        'canChange' => false,
                        'limitedId' => 3,
                        'list'      => []
                    ],
                    'button'     => [
                        'label' => 'Update',
                    ],
                    'labels' => [
                        'operations'       => 'Operations',
                        'isChangePassword' => 'Change password'
                    ]
                ]
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderAdminGetUser()
    {
        return [
            'adminGetUser' => [
                self::TYPE_FULL,
                3,
                [
                    'id'         => 3,
                    'name'       => [
                        'value'      => 'User',
                    ],
                    'login'      => [
                        'value'      => 'user',
                    ],
                    'email'      => [
                        'value'      => 'user@email.com',
                    ],
                    'type'       => [
                        'value' => UserModel::TYPE_LIMITED,
                    ],
                    'operations'
                        => $this->_dataProviderAdminGetUserOperations(),
                    'labels' => [
                        'operations'       => 'Operations',
                        'isChangePassword' => 'Change password'
                    ]
                ]
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderAdminGetUserOperations()
    {
        return [
            'canChange' => true,
            'limitedId' => 3,
            'list' => [
                Operation::TYPE_SECTIONS => [
                    'title' => 'Sections',
                    'data'  => $this->_dataProviderAdminGetUserSections()
                ],
                Operation::TYPE_BLOCKS   => [
                    'title' => 'Blocks',
                    'data'  => [
                        1 => [
                            'data' => $this->_dataProviderAdminGetUserBlock()
                        ]
                    ]
                ],
                Operation::TYPE_SETTINGS => [
                    'title' => 'Settings',
                    'data'  => $this->_dataProviderAdminGetUserSettings()
                ],
            ]
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderAdminGetUserSections()
    {
        return [
            Operation::ALL => [
                'title' => 'All',
                'data'  => [
                    [
                        'name'  => 'operations.SECTIONS.ALL.SECTION_ADD',
                        'value' => false
                    ]
                ]
            ],
            1              => [
                'title' => 'Text Blocks',
                'data'  => [
                    [
                        'name'  => 'operations.SECTIONS.1.SECTION_DELETE',
                        'value' => false
                    ],
                    [
                        'name'  => 'operations.SECTIONS.1.SECTION_DUPLICATE',
                        'value' => false
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
    private function _dataProviderAdminGetUserBlock()
    {
        return [
            Operation::ALL => [
                'title' => 'All',
                'data'  => [
                    [
                        'name'  => 'operations.BLOCKS.1.ALL.TEXT_ADD',
                        'value' => true
                    ],
                    [
                        'name'  => 'operations.BLOCKS.1.ALL.TEXT_DELETE',
                        'value' => true
                    ]
                ]
            ],
            1              => [
                'title' => 'Simple text',
                'data'  => [
                    [
                        'name'  => 'operations.BLOCKS.1.1.TEXT_DELETE',
                        'value' => false
                    ]
                ]
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderAdminGetUserSettings()
    {
        return [
            [
                'name'  => 'operations.SETTINGS.SETTINGS_USER_ADD',
                'value' => false
            ],
            [
                'name'  => 'operations.SETTINGS.SETTINGS_ICON',
                'value' => true
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderOwnerAddNewUser()
    {
        return [
            'ownerAddNewUser' => [
                self::TYPE_OWNER,
                null,
                [
                    'id'         => 0,
                    'title'      => 'Add user',
                    'name'       => [
                        'label'      => 'Name',
                        'value'      => '',
                        'name'       => 'name',
                        'validation' => [
                            'required' => 'required',
                            'maxLength' => 100,
                        ],
                    ],
                    'login'      => [
                        'label'      => 'Login',
                        'value'      => '',
                        'name'       => 'login',
                        'validation' => [
                            'required'                   => 'required',
                            'minLength'                  => 3,
                            'maxLength'                  => 50,
                            'latinDigitUnderscoreHyphen'
                                => 'latinDigitUnderscoreHyphen'
                        ],
                    ],
                    'email'      => [
                        'label'      => 'Email',
                        'value'      => '',
                        'name'       => 'email',
                        'validation' => [
                            'required' => 'required',
                            'email'    => 'email',
                        ],
                    ],
                    'type'       => [
                        'label' => 'Type',
                        'value' => 0,
                        'name'  => 'type',
                        'list'  => [
                            [
                                'key'   => 0,
                                'value' => 'Blocked'
                            ],
                            [
                                'key'   => 2,
                                'value' => 'Full'
                            ],
                            [
                                'key'   => 3,
                                'value' => 'Limited'
                            ]
                        ]
                    ],
                    'operations' => [
                        'canChange' => true,
                    ],
                    'button'     => [
                        'label' => 'Add',
                    ],
                    'labels' => [
                        'operations' => 'Operations',
                    ]
                ]
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderSmall1()
    {
        return [
            'ownerGetAdmin' => [
                self::TYPE_OWNER,
                2,
                [
                    'id'         => 2,
                    'name'       => [
                        'value'      => 'Admin',
                    ],
                    'login'      => [
                        'value'      => 'admin',
                    ],
                    'email'      => [
                        'value'      => 'admin@email.com',
                    ],
                    'type'       => [
                        'value' => UserModel::TYPE_FULL,
                    ],
                    'operations' => [
                        'canChange' => true,
                    ],
                ]
            ],
            'ownerGetUser' => [
                self::TYPE_OWNER,
                3,
                [
                    'id'         => 3,
                    'name'       => [
                        'value'      => 'User',
                    ],
                    'login'      => [
                        'value'      => 'user',
                    ],
                    'email'      => [
                        'value'      => 'user@email.com',
                    ],
                    'type'       => [
                        'value' => UserModel::TYPE_LIMITED,
                    ],
                    'operations' => [
                        'canChange' => true,
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
    private function _dataProviderSmall2()
    {
        return [
            'adminGetAdmin' => [
                self::TYPE_FULL,
                2,
                [
                    'id'         => 2,
                    'name'       => [
                        'value'      => 'Admin',
                    ],
                    'login'      => [
                        'value'      => 'admin',
                    ],
                    'email'      => [
                        'value'      => 'admin@email.com',
                    ],
                    'type'       => [
                        'value' => UserModel::TYPE_FULL,
                    ],
                    'operations' => [
                        'canChange' => false,
                    ],
                ]
            ],
            'adminAddNewUser' => [
                self::TYPE_FULL,
                null,
                [
                    'id'         => 0,
                    'title'      => 'Add user',
                    'name'       => [
                        'value'      => '',
                    ],
                    'login'      => [
                        'value'      => '',
                    ],
                    'email'      => [
                        'value'      => '',
                    ],
                    'type'       => [
                        'value' => 0,
                    ],
                    'operations' => [
                        'canChange' => true,
                    ],
                ]
            ],
            'userGetUser' => [
                self::TYPE_LIMITED,
                3,
                [
                    'id'         => 3,
                    'name'       => [
                        'value'      => 'User',
                    ],
                    'login'      => [
                        'value'      => 'user',
                    ],
                    'email'      => [
                        'value'      => 'user@email.com',
                    ],
                    'type'       => [
                        'value' => UserModel::TYPE_LIMITED,
                    ],
                    'operations' => [
                        'canChange' => false,
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
    private function _dataProviderError()
    {
        return [
            'adminGetOwner' => [
                self::TYPE_FULL,
                1,
                [],
                true
            ],
            'userGetOwner' => [
                self::TYPE_LIMITED,
                1,
                [],
                true
            ],
            'userGetAdmin' => [
                self::TYPE_LIMITED,
                2,
                [],
                true
            ],
            'userAddNewUser' => [
                self::TYPE_LIMITED,
                null,
                [],
                true
            ],
            'incorrectID1' => [
                self::TYPE_OWNER,
                'incorrect',
                [],
                true
            ],
            'incorrectID2' => [
                self::TYPE_OWNER,
                999,
                [],
                true
            ],
        ];
    }
}
