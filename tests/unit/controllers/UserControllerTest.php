<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
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
     * Test for getting login forms
     *
     * @param string $userType
     * @param array  $expectedData
     * @param bool   $isError
     *
     * @dataProvider dataProviderForTestGetLoginForms
     */
    public function testGetLoginForms($userType, $expectedData, $isError = false)
    {
        $this->setUser($userType);

        // Send request
        $this->sendRequest("user", "loginForms");

        $actualBody = $this->getBody();

        if ($isError) {
            $this->assertArrayHasKey("error", $actualBody);
        } else {
            $this->compareExpectedAndActual($expectedData, $actualBody, true);
        }
    }

    /**
     * Data provider for testGetLoginForms
     *
     * @return array
     */
    public function dataProviderForTestGetLoginForms()
    {
        return [
            [
                self::TYPE_OWNER,
                [],
                true
            ],
            [
                self::TYPE_LIMITED,
                [],
                true
            ],
            [
                null,
                [
                    "title" => "Login",
                    "forms" => [
                        "user"       => [
                            "name"       => "user",
                            "label"      => "User",
                            "validation" => [
                                "required"                   => "required",
                                "minLength"                  => 3,
                                "maxLength"                  => 50,
                                "latinDigitUnderscoreHyphen" => "latinDigitUnderscoreHyphen"
                            ]
                        ],
                        "password"   => [
                            "name"       => "password",
                            "label"      => "Password",
                            "validation" => [
                                "required"  => "required",
                                "minLength" => 3,
                                "maxLength" => 40,
                            ]
                        ],
                        "isRemember" => [
                            "name"  => "isRemember",
                            "label" => "Remember me",
                        ],
                        "button"     => [
                            "label"      => "Go",
                        ]
                    ]
                ]
            ],
        ];
    }

    /**
     * Test for creating session
     *
     * @param array $data
     * @param int   $expectedCode
     * @param array $expectedBody
     *
     * @dataProvider dataProviderForTestAddSSession
     *
     * @return bool
     */
    public function testCreateSession($data, $expectedCode = 200, $expectedBody = null)
    {
        $this->setUser(null);

        // Send request
        $this->sendRequest("user", "session", $data, "POST");

        // Check status code
        $this->assertSame($expectedCode, $this->getStatusCode());
        if ($expectedCode !== 200) {
            return true;
        }

        $actualBody = $this->getBody();

        // Check error response
        if ($expectedBody !== null) {
            $this->compareExpectedAndActual($expectedBody, $actualBody, true);
            return true;
        }

        // Getting record by token from response
        $this->assertTrue(count($actualBody) === 1);
        $token = $actualBody["token"];
        $userSessionModel = (new UserSessionModel)->byToken($token)->find();
        $this->assertInstanceOf("testS\\models\\UserSessionModel", $userSessionModel);

        // Make sure that logged User stores in memcache
        $memcached = App::getInstance()->getMemcached();
        $user = $memcached->get($token);
        $this->assertInstanceOf("testS\\components\\User", $user);

        // Check cookies
        $sessionIdFromCookie = $this->getSessionIdFromCookie();
        $this->assertSame(md5($sessionIdFromCookie), $token);
        $tokenFromCookie = $this->getTokenFromCookie();
        if ($data["isRemember"] === true) {
            $this->assertSame($tokenFromCookie, $token);
        } else {
            if ($tokenFromCookie !== "deleted") {
                $this->assertNull($tokenFromCookie);
            }
        }

        // Remove
        $userSessionModel->delete();
        $memcached->delete($token);
        $this->removeCookie();

        return true;
    }

    /**
     * Data provider for testAddSession
     *
     * @return array
     */
    public function dataProviderForTestAddSSession()
    {
        return [
            "emptyData"               => [
                "data" => [],
                400
            ],
            "emptyDataFields"         => [
                "data" => [
                    "user"       => "",
                    "password"   => "",
                    "isRemember" => "",
                ],
                400
            ],
            "incorrectTypeUser"       => [
                "data" => [
                    "user"       => 1,
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ],
                400
            ],
            "incorrectTypePassword"   => [
                "data" => [
                    "user"       => "user",
                    "password"   => 1,
                    "isRemember" => false,
                ],
                400
            ],
            "incorrectTypeIsRemember" => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => 1,
                ],
                400
            ],
            "incorrectPasswordLength" => [
                "data" => [
                    "user"       => "user",
                    "password"   => "pass",
                    "isRemember" => false,
                ],
                400
            ],
            "incorrectUser"           => [
                "data" => [
                    "user"       => "incorrect",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ],
                200,
                [
                    "errors" => [
                        "user" => "Incorrect user or password"
                    ]
                ]
            ],
            "incorrectPassword"       => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("incorrect" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ],
                200,
                [
                    "errors" => [
                        "password" => "Incorrect user or password"
                    ]
                ]
            ],
            "user"                    => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ],
                200
            ],
            "admin"                   => [
                "data" => [
                    "user"       => "admin",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => true,
                ],
                200
            ],
        ];
    }

    /**
     * Test for deleteSession
     *
     * @param string $user
     * @param string $token
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestDeleteSession
     */
    public function testDeleteSession($user, $token = null, $hasError = false)
    {
        $memcached = App::getInstance()->getMemcached();
        $this->setUser($user);

        $sessionsCountBeforeDelete = (new UserSessionModel())->getCount();

        if ($token !== null) {
            $sessionModel = (new UserSessionModel())->byToken($token)->find();
            $this->sendRequest("user", "session", ["token" => $token], "DELETE");
        } else {
            $sessionModel = (new UserSessionModel())->byToken($this->getUserToken())->find();
            $this->sendRequest("user", "session", [], "DELETE");
        }

        $sessionsCountAfterDelete = (new UserSessionModel())->getCount();

        if ($hasError === true) {
            $this->assertError();
            $this->assertSame($sessionsCountBeforeDelete, $sessionsCountAfterDelete);
            return true;
        } else {
            $this->assertSame($sessionsCountBeforeDelete - 1, $sessionsCountAfterDelete);
            $sessionModel->clearId()->save();

            $expectedBody = [
                "result" => true
            ];
            $this->assertSame($expectedBody, $this->getBody());
        }

        $memcachedResult = $memcached->get($sessionModel->get("token"));
        $this->assertFalse($memcachedResult);

        return true;
    }

    /**
     * Data provider for testDeleteSession
     *
     * @return array
     */
    public function dataProviderForTestDeleteSession()
    {
        return [
            "ownerDeleteOwner"     => [
                self::TYPE_OWNER,
                "c4ca4238a0b923820dcc509a6f75849b"
            ],
            "ownerDeleteHimself"   => [
                self::TYPE_OWNER
            ],
            "ownerDeleteAdmin"     => [
                self::TYPE_OWNER,
                "c81e728d9d4c2f636f067f89cc14862c"
            ],
            "ownerDeleteUser"      => [
                self::TYPE_OWNER,
                "eccbc87e4b5ce2fe28308fd9f2a7baf3"
            ],
            "adminDeleteOwner"     => [
                self::TYPE_FULL,
                "c4ca4238a0b923820dcc509a6f75849b",
                true
            ],
            "adminDeleteHimself"   => [
                self::TYPE_OWNER
            ],
            "adminDeleteAdmin"     => [
                self::TYPE_OWNER,
                "c81e728d9d4c2f636f067f89cc14862c",
            ],
            "adminDeleteUser"      => [
                self::TYPE_OWNER,
                "eccbc87e4b5ce2fe28308fd9f2a7baf3",
            ],
            "limitedDeleteOwner"   => [
                self::TYPE_LIMITED,
                "c4ca4238a0b923820dcc509a6f75849b",
                true
            ],
            "limitedDeleteHimself" => [
                self::TYPE_LIMITED
            ],
            "limitedDeleteAdmin"   => [
                self::TYPE_LIMITED,
                "c81e728d9d4c2f636f067f89cc14862c",
                true
            ],
            "limitedDeleteUser"    => [
                self::TYPE_LIMITED,
                "eccbc87e4b5ce2fe28308fd9f2a7baf3"
            ],
        ];
    }

    /**
     * Test for method deleteSessions
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestDeleteSessions
     */
    public function testDeleteSessions($user, $id = null, $hasError = false)
    {
        $memcached = App::getInstance()->getMemcached();
        $this->setUser($user);

        $sessionsToDelete = (new UserSessionModel())->byUserId($id)->findAll();
        foreach ($sessionsToDelete as $sessionModel) {
            $this->assertNotNull($sessionModel);
        }

        if ($id === null) {
            $this->sendRequest("user", "sessions", [], "DELETE");
        } else {
            $this->sendRequest("user", "sessions", ["id" => $id], "DELETE");
        }

        if ($hasError === true) {
            $this->assertError();

            foreach ($sessionsToDelete as $sessionModel) {
                $this->assertNotNull((new UserSessionModel())->byId($sessionModel->getId())->find());
            }
        } else {
            foreach ($sessionsToDelete as $sessionModel) {
                if ($sessionModel->get("token") === $this->getUserToken()) {
                    $this->assertNotNull((new UserSessionModel())->byId($sessionModel->getId())->find());
                } else {
                    $this->assertNull((new UserSessionModel())->byId($sessionModel->getId())->find());
                    $memcachedResult = $memcached->get($sessionModel->get("token"));
                    $this->assertFalse($memcachedResult);
                    $sessionModel->clearId()->save();
                }
            }
        }
    }

    /**
     * Data provider for testDeleteSessions
     *
     * @return array
     */
    public function dataProviderForTestDeleteSessions()
    {
        return [
            "ownerDeleteOwner"     => [
                self::TYPE_OWNER,
                1
            ],
            "ownerDeleteHimself"   => [
                self::TYPE_OWNER
            ],
            "ownerDeleteAdmin"     => [
                self::TYPE_OWNER,
                2
            ],
            "ownerDeleteUser"      => [
                self::TYPE_OWNER,
                3
            ],
            "adminDeleteOwner"     => [
                self::TYPE_FULL,
                1,
                true
            ],
            "adminDeleteHimself"   => [
                self::TYPE_OWNER
            ],
            "adminDeleteAdmin"     => [
                self::TYPE_OWNER,
                2
            ],
            "adminDeleteUser"      => [
                self::TYPE_OWNER,
                3
            ],
            "limitedDeleteOwner"   => [
                self::TYPE_LIMITED,
                1,
                true
            ],
            "limitedDeleteHimself" => [
                self::TYPE_LIMITED
            ],
            "limitedDeleteAdmin"   => [
                self::TYPE_LIMITED,
                2,
                true
            ],
            "limitedDeleteUser"    => [
                self::TYPE_LIMITED,
                3
            ],
        ];
    }

    /**
     * Test for getSessions method
     */
    public function testGetsSessions()
    {
        // Add new session for user 1
        $newToken = $this->generateStringWithLength(32);
        $newUserSessionModel = new UserSessionModel();
        $newUserSessionModel->set(
            [
                "userId" => 1,
                "token"  => $newToken,
                "ip"     => "127.0.0.7",
                "ua"     => "",
            ]
        );
        $newUserSessionModel->save();

        // Send request
        $this->sendRequest("user", "sessions", ["id" => 1]);
        $actualBody = $this->getBody();

        // Make sure that records for User 1 only returned
        $allUserSessionModels = (new UserSessionModel())->findAll();
        $this->assertTrue(count($allUserSessionModels) - count($actualBody["list"]) > 0);

        // Check response content
        foreach ($actualBody["list"] as $result) {
            switch ($result["token"]) {
                case self::TOKEN_OWNER:
                    $expectedResult = [
                        "ip"        => "127.0.0.1",
                        "platform"  => "Windows",
                        "browser"   => "Firefox",
                        "version"   => "4.0.1",
                        "isCurrent" => true,
                        "isOnline"  => true
                    ];
                    $this->compareExpectedAndActual($expectedResult, $result);
                    break;
                case $newToken:
                    $expectedResult = [
                        "ip"        => "127.0.0.7",
                        "platform"  => null,
                        "browser"   => null,
                        "version"   => null,
                        "isCurrent" => false,
                        "isOnline"  => true
                    ];
                    $this->compareExpectedAndActual($expectedResult, $result);
            }
        }

        // Remove test session
        $newUserSessionModel->delete();
    }

    /**
     * Test for getUsers
     *
     * @param string $user
     * @param array  $expected
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestGetUsers
     */
    public function testGetUsers($user, $expected, $hasError = false)
    {
        $this->setUser($user);
        $this->sendRequest("user", "users");

        if ($hasError === false) {
            $this->compareExpectedAndActual($expected, $this->getBody(), true);
        } else {
            $this->assertError();
        }
    }

    /**
     * Data provider for testGetUsers
     *
     * @return array
     */
    public function dataProviderForTestGetUsers()
    {
        return [
            [
                null,
                [],
                true
            ],
            [
                self::TYPE_NO_OPERATIONS_USER,
                [
                    "title"  => "Users",
                    "list"   => [
                        [
                            "id"              => 4,
                            "name"            => "User with no operations",
                            "email"           => "test-operation@email.com",
                            "access"          => "Limited",
                            "canUpdate"       => true,
                            "canDelete"       => false,
                            "canViewSessions" => true,
                            "isCurrent"       => true,
                        ]
                    ],
                    "canAdd" => false,
                    "labels" => [
                        "name"                  => "Name",
                        "access"                => "Access",
                        "sessions"              => "Sessions",
                        "edit"                  => "Edit",
                        "delete"                => "Delete",
                        "add"                   => "Add",
                        "email"                 => "Email",
                        "deleteUserConfirmText" => "Are you sure to delete the user?",
                        "no"                    => "No",
                    ]
                ]
            ],
            [
                self::TYPE_FULL,
                [
                    "title"  => "Users",
                    "list"   => [
                        [
                            "id"              => 2,
                            "name"            => "Admin",
                            "email"           => "admin@email.com",
                            "access"          => "Full",
                            "canUpdate"       => true,
                            "canDelete"       => false,
                            "canViewSessions" => true,
                            "isCurrent"       => true,
                        ],
                        [
                            "id"              => 5,
                            "name"            => "Blocked User",
                            "email"           => "blocked@email.com",
                            "access"          => "Blocked",
                            "canUpdate"       => true,
                            "canDelete"       => true,
                            "canViewSessions" => true,
                            "isCurrent"       => false,
                        ],
                        [
                            "id"              => 1,
                            "name"            => "Owner",
                            "email"           => "owner@email.com",
                            "access"          => "Owner",
                            "canUpdate"       => false,
                            "canDelete"       => false,
                            "canViewSessions" => true,
                            "isCurrent"       => false,
                        ],
                        [
                            "id"              => 3,
                            "name"            => "User",
                            "email"           => "user@email.com",
                            "access"          => "Limited",
                            "canUpdate"       => true,
                            "canDelete"       => true,
                            "canViewSessions" => true,
                            "isCurrent"       => false,
                        ],
                        [
                            "id"              => 4,
                            "name"            => "User with no operations",
                            "email"           => "test-operation@email.com",
                            "access"          => "Limited",
                            "canUpdate"       => true,
                            "canDelete"       => true,
                            "canViewSessions" => true,
                            "isCurrent"       => false,
                        ],
                    ],
                    "canAdd" => true,
                    "labels" => [
                        "name"                  => "Name",
                        "access"                => "Access",
                        "sessions"              => "Sessions",
                        "edit"                  => "Edit",
                        "delete"                => "Delete",
                        "add"                   => "Add",
                        "email"                 => "Email",
                        "deleteUserConfirmText" => "Are you sure to delete the user?",
                        "no"                    => "No",
                    ]
                ]
            ],
        ];
    }

    /**
     * Test for getUser
     *
     * @param string $user
     * @param int    $id
     * @param array  $expected
     * @param bool   $isError
     *
     * @dataProvider dataProviderForTestGetUser
     */
    public function testGetUser($user, $id, $expected, $isError = false)
    {
        $this->setUser($user);
        $this->sendRequest("user", "user", ["id" => $id]);

        if ($isError) {
            $this->assertError();
        } else {
            $this->compareExpectedAndActual($expected, $this->getBody());
        }
    }

    /**
     * Data provider for testGetUser
     *
     * @return array
     */
    public function dataProviderForTestGetUser()
    {
        return [
            "ownerGetOwner" => [
                self::TYPE_OWNER,
                1,
                [
                    "id"         => 1,
                    "title"      => "Edit user",
                    "name"       => [
                        "label"      => "Name",
                        "value"      => "Owner",
                        "name"       => "name",
                        "validation" => [
                            "required" => "required",
                            "maxLength" => 100,
                        ],
                    ],
                    "login"      => [
                        "label"      => "Login",
                        "value"      => "owner",
                        "name"       => "login",
                        "validation" => [
                            "required"                   => "required",
                            "minLength"                  => 3,
                            "maxLength"                  => 50,
                            "latinDigitUnderscoreHyphen" => "latinDigitUnderscoreHyphen"
                        ],
                    ],
                    "email"      => [
                        "label"      => "Email",
                        "value"      => "owner@email.com",
                        "name"       => "email",
                        "validation" => [
                            "required" => "required",
                            "email"    => "email",
                        ],
                    ],
                    "type"       => [
                        "label" => "Type",
                        "value" => UserModel::TYPE_OWNER,
                        "name"  => "type",
                        "list"  => [
                            [
                                "key"   => 0,
                                "value" => "Blocked"
                            ],
                            [
                                "key"   => 2,
                                "value" => "Full"
                            ],
                            [
                                "key"   => 3,
                                "value" => "Limited"
                            ]
                        ]
                    ],
                    "operations" => [
                        "canChange" => false,
                        "limitedId" => 3,
                        "list"      => []
                    ],
                    "button"     => [
                        "label" => "Update",
                    ],
                    "labels" => [
                        "operations"       => "Operations",
                        "isChangePassword" => "Change password"
                    ]
                ]
            ],
            "ownerGetAdmin" => [
                self::TYPE_OWNER,
                2,
                [
                    "id"         => 2,
                    "name"       => [
                        "value"      => "Admin",
                    ],
                    "login"      => [
                        "value"      => "admin",
                    ],
                    "email"      => [
                        "value"      => "admin@email.com",
                    ],
                    "type"       => [
                        "value" => UserModel::TYPE_FULL,
                    ],
                    "operations" => [
                        "canChange" => true,
                    ],
                ]
            ],
            "ownerGetUser" => [
                self::TYPE_OWNER,
                3,
                [
                    "id"         => 3,
                    "name"       => [
                        "value"      => "User",
                    ],
                    "login"      => [
                        "value"      => "user",
                    ],
                    "email"      => [
                        "value"      => "user@email.com",
                    ],
                    "type"       => [
                        "value" => UserModel::TYPE_LIMITED,
                    ],
                    "operations" => [
                        "canChange" => true,
                    ],
                ]
            ],
            "adminGetOwner" => [
                self::TYPE_FULL,
                1,
                [],
                true
            ],
            "adminGetAdmin" => [
                self::TYPE_FULL,
                2,
                [
                    "id"         => 2,
                    "name"       => [
                        "value"      => "Admin",
                    ],
                    "login"      => [
                        "value"      => "admin",
                    ],
                    "email"      => [
                        "value"      => "admin@email.com",
                    ],
                    "type"       => [
                        "value" => UserModel::TYPE_FULL,
                    ],
                    "operations" => [
                        "canChange" => false,
                    ],
                ]
            ],
            "adminGetUser" => [
                self::TYPE_FULL,
                3,
                [
                    "id"         => 3,
                    "name"       => [
                        "value"      => "User",
                    ],
                    "login"      => [
                        "value"      => "user",
                    ],
                    "email"      => [
                        "value"      => "user@email.com",
                    ],
                    "type"       => [
                        "value" => UserModel::TYPE_LIMITED,
                    ],
                    "operations" => [
                        "canChange" => true,
                        "limitedId" => 3,
                        "list" => [
                            Operation::TYPE_SECTIONS => [
                                "title" => "Sections",
                                "data"  => [
                                    Operation::ALL => [
                                        "title" => "All",
                                        "data"  => [
                                            [
                                                "name"  => "operations.SECTIONS.ALL.SECTION_ADD",
                                                "value" => false
                                            ]
                                        ]
                                    ],
                                    1              => [
                                        "title" => "Text Blocks",
                                        "data"  => [
                                            [
                                                "name"  => "operations.SECTIONS.1.SECTION_DELETE",
                                                "value" => false
                                            ],
                                            [
                                                "name"  => "operations.SECTIONS.1.SECTION_DUPLICATE",
                                                "value" => false
                                            ],
                                        ]
                                    ],
                                ]
                            ],
                            Operation::TYPE_BLOCKS   => [
                                "title" => "Blocks",
                                "data"  => [
                                    1 => [
                                        "data" => [
                                            Operation::ALL => [
                                                "title" => "All",
                                                "data"  => [
                                                    [
                                                        "name"  => "operations.BLOCKS.1.ALL.TEXT_ADD",
                                                        "value" => true
                                                    ],
                                                    [
                                                        "name"  => "operations.BLOCKS.1.ALL.TEXT_DELETE",
                                                        "value" => true
                                                    ]
                                                ]
                                            ],
                                            1              => [
                                                "title" => "Simple text",
                                                "data"  => [
                                                    [
                                                        "name"  => "operations.BLOCKS.1.1.TEXT_DELETE",
                                                        "value" => false
                                                    ]
                                                ]
                                            ],
                                        ]
                                    ]
                                ]
                            ],
                            Operation::TYPE_SETTINGS => [
                                "title" => "Settings",
                                "data"  => [
                                    [
                                        "name"  => "operations.SETTINGS.SETTINGS_USER_ADD",
                                        "value" => false
                                    ],
                                    [
                                        "name"  => "operations.SETTINGS.SETTINGS_ICON",
                                        "value" => true
                                    ],
                                ]
                            ],
                        ]
                    ],
                    "labels" => [
                        "operations"       => "Operations",
                        "isChangePassword" => "Change password"
                    ]
                ]
            ],
            "userGetOwner" => [
                self::TYPE_LIMITED,
                1,
                [],
                true
            ],
            "userGetAdmin" => [
                self::TYPE_LIMITED,
                2,
                [],
                true
            ],
            "userGetUser" => [
                self::TYPE_LIMITED,
                3,
                [
                    "id"         => 3,
                    "name"       => [
                        "value"      => "User",
                    ],
                    "login"      => [
                        "value"      => "user",
                    ],
                    "email"      => [
                        "value"      => "user@email.com",
                    ],
                    "type"       => [
                        "value" => UserModel::TYPE_LIMITED,
                    ],
                    "operations" => [
                        "canChange" => false,
                    ],
                ]
            ],
            "ownerAddNewUser" => [
                self::TYPE_OWNER,
                null,
                [
                    "id"         => 0,
                    "title"      => "Add user",
                    "name"       => [
                        "label"      => "Name",
                        "value"      => "",
                        "name"       => "name",
                        "validation" => [
                            "required" => "required",
                            "maxLength" => 100,
                        ],
                    ],
                    "login"      => [
                        "label"      => "Login",
                        "value"      => "",
                        "name"       => "login",
                        "validation" => [
                            "required"                   => "required",
                            "minLength"                  => 3,
                            "maxLength"                  => 50,
                            "latinDigitUnderscoreHyphen" => "latinDigitUnderscoreHyphen"
                        ],
                    ],
                    "email"      => [
                        "label"      => "Email",
                        "value"      => "",
                        "name"       => "email",
                        "validation" => [
                            "required" => "required",
                            "email"    => "email",
                        ],
                    ],
                    "type"       => [
                        "label" => "Type",
                        "value" => 0,
                        "name"  => "type",
                        "list"  => [
                            [
                                "key"   => 0,
                                "value" => "Blocked"
                            ],
                            [
                                "key"   => 2,
                                "value" => "Full"
                            ],
                            [
                                "key"   => 3,
                                "value" => "Limited"
                            ]
                        ]
                    ],
                    "operations" => [
                        "canChange" => true,
                    ],
                    "button"     => [
                        "label" => "Add",
                    ],
                    "labels" => [
                        "operations" => "Operations",
                    ]
                ]
            ],
            "adminAddNewUser" => [
                self::TYPE_FULL,
                null,
                [
                    "id"         => 0,
                    "title"      => "Add user",
                    "name"       => [
                        "value"      => "",
                    ],
                    "login"      => [
                        "value"      => "",
                    ],
                    "email"      => [
                        "value"      => "",
                    ],
                    "type"       => [
                        "value" => 0,
                    ],
                    "operations" => [
                        "canChange" => true,
                    ],
                ]
            ],
            "userAddNewUser" => [
                self::TYPE_LIMITED,
                null,
                [],
                true
            ],
            "incorrectID1" => [
                self::TYPE_OWNER,
                "incorrect",
                [],
                true
            ],
            "incorrectID2" => [
                self::TYPE_OWNER,
                999,
                [],
                true
            ],
        ];
    }

    /**
     * Test for method createUser
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasException
     * @param array  $expectedErrors
     * @param bool   $isSuccess
     * @param array  $expectedOperations
     *
     * @dataProvider dataProviderForTestAddUser
     *
     * @return bool
     */
    public function testCreateUser(
        $user,
        $data,
        $hasException,
        $expectedErrors = null,
        $isSuccess = false,
        $expectedOperations = null
    )
    {
        $this->setUser($user);
        $this->sendRequest("user", "user", $data, "POST");

        if ($hasException === true) {
            $this->assertError();
            return true;
        }

        $actual = $this->getBody();

        if ($isSuccess === true) {
            $this->compareExpectedAndActual(
                [
                    "result" => true,
                    "users"  => [
                        "title" => "Users"
                    ]
                ],
                $actual
            );

            $model = (new UserModel())->latest()->find();

            if ($expectedOperations !== null) {
                $this->compareExpectedAndActual($expectedOperations, $model->getOperations(), true);
            }

            $model->delete();
        } else {
            $this->compareExpectedAndActual($expectedErrors, $actual, true);
        }

        return true;
    }

    /**
     * Data provider for testAddUser
     *
     * @return array
     */
    public function dataProviderForTestAddUser()
    {
        $password1 = $this->generateStringWithLength(32);
        $password2 = $this->generateStringWithLength(32);

        return [
            0  => [
                self::TYPE_NO_OPERATIONS_USER,
                [
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
            1  => [
                self::TYPE_BLOCKED_USER,
                [
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
            2  => [
                self::TYPE_FULL,
                [
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            3  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            4  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            5  => [
                self::TYPE_FULL,
                [
                    "name"       => "Name",
                    "login"      => "newLogin",
                    "password"   => $password1,
                    "type"       => UserModel::TYPE_LIMITED,
                    "email"      => "newEmail@email.com",
                    "operations" => []
                ],
                true
            ],
            6  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            7  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "operations"      => []
                ],
                true
            ],
            8  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password2,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                false,
                [
                    "errors" => [
                        "passwordConfirm" => "Passwords do not match"
                    ]
                ]
            ],
            9  => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "user",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "user@email.com",
                    "operations"      => []
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
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_BLOCKED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                false,
                null,
                true
            ],
            11 => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_BLOCKED,
                    "email"           => "newEmail@email.com",
                    "operations"      => [
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
            12 => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_BLOCKED,
                    "email"           => "newEmail@email.com",
                ],
                true
            ],
            13 => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_BLOCKED,
                    "email"           => "newEmail@email.com",
                    "operations"      => [
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
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "passwordConfirm" => $password1,
                    "type"            => UserModel::TYPE_BLOCKED,
                    "email"           => "newEmail@email.com",
                    "operations"      => [
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