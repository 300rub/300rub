<?php

namespace testS\tests\unit\controllers\user;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetUsersController
 */
class GetUsersControllerTest extends AbstractControllerTest
{

    /**
     * Test for getUsers
     *
     * @param string $user     User type
     * @param array  $expected Expected result
     * @param bool   $hasError Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $expected, $hasError = null)
    {
        $this->setUser($user);
        $this->sendRequest('user', 'users');

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual(
            $expected,
            $this->getBody(),
            true
        );
        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            $this->_dataProviderGuest(),
            $this->_dataProviderNoOperationUser(),
            $this->_dataProviderAdmin(),
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderGuest()
    {
        return [
            null,
            [],
            true
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderNoOperationUser()
    {
        return [
            self::TYPE_NO_OPERATIONS_USER,
            [
                'title'  => 'Users',
                'list'   => [
                    [
                        'id'              => 4,
                        'name'            => 'User with no operations',
                        'email'           => 'test-operation@email.com',
                        'access'          => 'Limited',
                        'canUpdate'       => true,
                        'canDelete'       => false,
                        'canViewSessions' => true,
                        'isCurrent'       => true,
                    ]
                ],
                'canAdd' => false,
                'labels' => [
                    'name'                  => 'Name',
                    'access'                => 'Access',
                    'sessions'              => 'Sessions',
                    'edit'                  => 'Edit',
                    'delete'                => 'Delete',
                    'add'                   => 'Add',
                    'email'                 => 'Email',
                    'deleteUserConfirmText'
                        => 'Are you sure to delete the user?',
                    'no'                    => 'No',
                ]
            ]
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProviderAdmin()
    {
        return [
            self::TYPE_FULL,
            [
                'title'  => 'Users',
                'list'   => [
                    [
                        'id'              => 2,
                        'name'            => 'Admin',
                        'email'           => 'admin@email.com',
                        'access'          => 'Full',
                        'canUpdate'       => true,
                        'canDelete'       => false,
                        'canViewSessions' => true,
                        'isCurrent'       => true,
                    ],
                    [
                        'id'              => 5,
                        'name'            => 'Blocked User',
                        'email'           => 'blocked@email.com',
                        'access'          => 'Blocked',
                        'canUpdate'       => true,
                        'canDelete'       => true,
                        'canViewSessions' => true,
                        'isCurrent'       => false,
                    ],
                    [
                        'id'              => 1,
                        'name'            => 'Owner',
                        'email'           => 'owner@email.com',
                        'access'          => 'Owner',
                        'canUpdate'       => false,
                        'canDelete'       => false,
                        'canViewSessions' => true,
                        'isCurrent'       => false,
                    ],
                    [
                        'id'              => 3,
                        'name'            => 'User',
                        'email'           => 'user@email.com',
                        'access'          => 'Limited',
                        'canUpdate'       => true,
                        'canDelete'       => true,
                        'canViewSessions' => true,
                        'isCurrent'       => false,
                    ],
                    [
                        'id'              => 4,
                        'name'            => 'User with no operations',
                        'email'           => 'test-operation@email.com',
                        'access'          => 'Limited',
                        'canUpdate'       => true,
                        'canDelete'       => true,
                        'canViewSessions' => true,
                        'isCurrent'       => false,
                    ],
                ],
                'canAdd' => true,
                'labels' => [
                    'name'                  => 'Name',
                    'access'                => 'Access',
                    'sessions'              => 'Sessions',
                    'edit'                  => 'Edit',
                    'delete'                => 'Delete',
                    'add'                   => 'Add',
                    'email'                 => 'Email',
                    'deleteUserConfirmText'
                        => 'Are you sure to delete the user?',
                    'no'                    => 'No',
                ]
            ]
        ];
    }
}
