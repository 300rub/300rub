<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
use testS\components\Operation;
use testS\components\User;
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
                            "type"       => "text",
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
                            "type"       => "password",
                            "label"      => "Password",
                            "validation" => [
                                "required"  => "required",
                                "minLength" => 3,
                                "maxLength" => 40,
                            ]
                        ],
                        "isRemember" => [
                            "name"  => "isRemember",
                            "type"  => "checkbox",
                            "label" => "Remember me",
                        ],
                        "button"     => [
                            "type"       => "button",
                            "label"      => "Go",
                            "controller" => "user",
                            "action"     => "session"
                        ]
                    ]
                ]
            ],
        ];
    }

    /**
     * Test for adding session
     *
     * @param array $data
     * @param int   $expectedCode
     * @param array $expectedBody
     *
     * @dataProvider dataProviderForTestAddSSession
     *
     * @return bool
     */
    public function testAddSession($data, $expectedCode = 200, $expectedBody = null)
    {
        $this->setUser(null);

        // Send request
        $this->sendRequest("user", "session", $data, "PUT");

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
     * Test for deleteSession method
     *
     * @param string $userType
     * @param string $token
     * @param string $sessionId
     * @param bool   $isRemoved
     *
     * @dataProvider dataProviderForTestDeleteSession
     */
    public function testDeleteSession($userType, $token = "", $sessionId = "", $isRemoved = true)
    {
        $memcached = App::getInstance()->getMemcached();

        // Set user
        $this->setUser($userType, $token, $sessionId);

        // Getting session before delete
        $sessionBeforeDelete = (new UserSessionModel())->byToken($this->getUserToken())->find();

        if ($isRemoved === true) {
            $this->assertInstanceOf("\\testS\\models\\UserSessionModel", $sessionBeforeDelete);
        } else {
            $this->assertNull($sessionBeforeDelete);
        }

        // Getting all sessions
        $sessionsCountBeforeLogOut = count((new UserSessionModel())->findAll());

        // Send request
        $this->sendRequest("user", "session", [], "DELETE");

        // Check sessions in DB and Memcached
        $sessionsCountAfterLogOut = count((new UserSessionModel())->findAll());
        if ($isRemoved === true) {
            $this->assertSame($sessionsCountBeforeLogOut - 1, $sessionsCountAfterLogOut);

            $sessionAfterDelete = (new UserSessionModel())->byToken($this->getUserToken())->find();
            $this->assertNull($sessionAfterDelete);

            // Check memcached
            $memcachedResult = $memcached->get($sessionBeforeDelete->get("token"));
            $this->assertFalse($memcachedResult);
        } else {
            $this->assertSame($sessionsCountBeforeLogOut, $sessionsCountAfterLogOut);
        }

        // Check body
        $actualBody = $this->getBody();
        $expectedBody = [
            "result" => true
        ];
        $this->assertSame($expectedBody, $actualBody);

        // Rollback session
        if ($isRemoved === true) {
            $sessionBeforeDelete->clearId()->save();
        }
    }

    /**
     * Data provider for testDeleteSession
     *
     * @return array
     */
    public function dataProviderForTestDeleteSession()
    {
        return [
            "guest"    => [
                null,
                "",
                "",
                false
            ],
            "owner"    => [
                self::TYPE_OWNER,
                "",
                "",
                true
            ],
            "admin"    => [
                self::TYPE_FULL,
                "",
                "",
                true
            ],
            "user"     => [
                self::TYPE_LIMITED,
                "",
                "",
                true
            ],
            "badToken" => [
                null,
                "incorrect",
                null,
                false
            ],
        ];
    }

    /**
     * Test for deleteSession method with token data
     *
     * @param string $tokenToCreate
     * @param string $tokenToDelete
     * @param bool   $isRemoved
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestDeleteSessionByToken
     */
    public function testDeleteSessionByToken($tokenToCreate, $tokenToDelete, $isRemoved, $hasError)
    {
        // Create test session to delete
        $newUserSessionModel = new UserSessionModel();
        $newUserSessionModel->set(
            [
                "userId" => 1,
                "token"  => $tokenToCreate,
                "ip"     => "127.0.0.7",
                "ua"     => ""
            ]
        );
        $newUserSessionModel->save();

        $allUserSessionModelsBeforeDelete = (new UserSessionModel())->findAll();

        // Delete latest session
        $this->sendRequest("user", "session", ["token" => $tokenToDelete], "DELETE");

        $allUserSessionModelsAfterDelete = (new UserSessionModel())->findAll();

        if ($isRemoved === true) {
            $this->assertSame(count($allUserSessionModelsBeforeDelete) - 1, count($allUserSessionModelsAfterDelete));
            $expectedBody = [
                "result" => true
            ];
            $this->assertSame($expectedBody, $this->getBody());
        } else {
            $this->assertSame(count($allUserSessionModelsBeforeDelete), count($allUserSessionModelsAfterDelete));
            $this->assertTrue(array_key_exists("error", $this->getBody()) === $hasError);

            $newUserSessionModel->delete();
        }
    }

    /**
     * Data provider for testDeleteSessionByToken
     *
     * @return array
     */
    public function dataProviderForTestDeleteSessionByToken()
    {
        $token = $this->generateStringWithLength(32);

        return [
            "ownerSuccess"     => [
                $token,
                $token,
                true,
                false
            ],
            "tokenNotExist"    => [
                $token,
                $this->generateStringWithLength(32),
                false,
                false
            ],
            "anotherUserToken" => [
                $token,
                self::TOKEN_FULL,
                false,
                true
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
        $this->sendRequest("user", "sessions");
        $actualBody = $this->getBody();

        // Make sure that records for User 1 only returned
        $allUserSessionModels = (new UserSessionModel())->findAll();
        $this->assertTrue(count($allUserSessionModels) - count($actualBody["result"]) > 0);
        $returnedTokens = [];
        foreach ($actualBody["result"] as $result) {
            $returnedTokens[] = $result["token"];
        }
        foreach ($allUserSessionModels as $userSessionModel) {
            if ($userSessionModel->get("userId") === 1) {
                $this->assertTrue(in_array($userSessionModel->get("token"), $returnedTokens));
            }
        }

        // Check response content
        foreach ($actualBody["result"] as $result) {
            switch ($result["token"]) {
                case self::TOKEN_OWNER:
                    $expectedResult = [
                        "ip"        => "127.0.0.1",
                        "token"     => self::TOKEN_OWNER,
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
                        "token"     => $newToken,
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
     * Test for deleteSessions method
     */
    public function testDeleteSessions()
    {
        $memcached = App::getInstance()->getMemcached();

        /**
         * @var UserModel $userModel
         */
        $userModel = (new UserModel)->byId(1)->find();

        // Add 2 sessions for Owner
        $newToken1 = $this->generateStringWithLength(32);
        $newUserSessionModel1 = new UserSessionModel();
        $newUserSessionModel1->set(
            [
                "userId" => 1,
                "token"  => $newToken1,
                "ip"     => "127.0.0.1",
                "ua"     => "",
            ]
        );
        $newUserSessionModel1->save();
        $memcached->set($newToken1, new User($newToken1, $userModel));
        $newToken2 = $this->generateStringWithLength(32);
        $newUserSessionModel2 = new UserSessionModel();
        $newUserSessionModel2->set(
            [
                "userId" => 1,
                "token"  => $newToken2,
                "ip"     => "127.0.0.2",
                "ua"     => "",
            ]
        );
        $newUserSessionModel2->save();
        $memcached->set($newToken2, new User($newToken1, $userModel));

        // Make sure that count of owner sessions >= 3
        $this->assertTrue(3 <= (new UserSessionModel())->byUserId(1)->getCount());

        // Delete sessions
        $this->sendRequest("user", "sessions", [], "DELETE");

        // Make sure that count of owner sessions is 1
        $this->assertSame(1, (new UserSessionModel())->byUserId(1)->getCount());
        $this->assertNull((new UserSessionModel())->byToken($newToken1)->find());
        $this->assertNull((new UserSessionModel())->byToken($newToken2)->find());
        $this->assertFalse($memcached->get($newToken1));
        $this->assertFalse($memcached->get($newToken2));
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
                    "title" => "Users",
                    "list"   => [
                        [
                            "id"               => 4,
                            "name"             => "User with no operations",
                            "email"            => "test-operation@email.com",
                            "access"           => "Limited",
                            "canUpdate"        => true,
                            "canDelete"        => true,
                            "canViewSessions"  => true,
                            "canDeleteSession" => true,
                            "isCurrent"        => true,
                        ]
                    ],
                    "canAdd" => false,
                    "labels" => [
                        "name"     => "Name",
                        "access"   => "Access",
                        "sessions" => "Sessions",
                        "edit"     => "Edit",
                        "delete"   => "Delete",
                        "open"     => "Open",
                        "add"      => "Add",
                        "email"    => "Email"
                    ]
                ]
            ],
            [
                self::TYPE_FULL,
                [
                    "title" => "Users",
                    "list"   => [
                        [
                            "id"               => 2,
                            "name"             => "Admin",
                            "email"            => "admin@email.com",
                            "access"           => "Full",
                            "canUpdate"        => true,
                            "canDelete"        => true,
                            "canViewSessions"  => true,
                            "canDeleteSession" => true,
                            "isCurrent"        => true,
                        ],
                        [
                            "id"               => 5,
                            "name"             => "Blocked User",
                            "email"            => "blocked@email.com",
                            "access"           => "Blocked",
                            "canUpdate"        => true,
                            "canDelete"        => true,
                            "canViewSessions"  => true,
                            "canDeleteSession" => true,
                            "isCurrent"        => false,
                        ],
                        [
                            "id"               => 1,
                            "name"             => "Owner",
                            "email"            => "owner@email.com",
                            "access"           => "Owner",
                            "canUpdate"        => false,
                            "canDelete"        => false,
                            "canViewSessions"  => true,
                            "canDeleteSession" => false,
                            "isCurrent"        => false,
                        ],
                        [
                            "id"               => 3,
                            "name"             => "User",
                            "email"            => "user@email.com",
                            "access"           => "Limited",
                            "canUpdate"        => true,
                            "canDelete"        => true,
                            "canViewSessions"  => true,
                            "canDeleteSession" => true,
                            "isCurrent"        => false,
                        ],
                        [
                            "id"               => 4,
                            "name"             => "User with no operations",
                            "email"            => "test-operation@email.com",
                            "access"           => "Limited",
                            "canUpdate"        => true,
                            "canDelete"        => true,
                            "canViewSessions"  => true,
                            "canDeleteSession" => true,
                            "isCurrent"        => false,
                        ],
                    ],
                    "canAdd" => true,
                    "labels" => [
                        "name"     => "Name",
                        "access"   => "Access",
                        "sessions" => "Sessions",
                        "edit"     => "Edit",
                        "delete"   => "Delete",
                        "open"     => "Open",
                        "add"      => "Add",
                        "email"    => "Email"
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
        $this->compareExpectedAndActual($expected, $this->getBody());

        if ($isError) {
            $this->assertError();
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
            [
                self::TYPE_OWNER,
                1,
                [
                    "name"                => "Owner",
                    "login"               => "owner",
                    "email"               => "owner@email.com",
                    "type"                => UserModel::TYPE_OWNER,
                    "canChangeOperations" => false,
                ]
            ],
            [
                self::TYPE_OWNER,
                2,
                [
                    "name"                => "Admin",
                    "login"               => "admin",
                    "email"               => "admin@email.com",
                    "type"                => UserModel::TYPE_FULL,
                    "canChangeOperations" => true,
                ]
            ],
            [
                self::TYPE_OWNER,
                3,
                [
                    "name"                => "User",
                    "login"               => "user",
                    "email"               => "user@email.com",
                    "type"                => UserModel::TYPE_LIMITED,
                    "canChangeOperations" => true,
                ]
            ],
            [
                self::TYPE_FULL,
                1,
                [
                    "name"                => "Owner",
                    "login"               => "owner",
                    "email"               => "owner@email.com",
                    "type"                => UserModel::TYPE_OWNER,
                    "canChangeOperations" => false,
                ]
            ],
            [
                self::TYPE_FULL,
                2,
                [
                    "name"                => "Admin",
                    "login"               => "admin",
                    "email"               => "admin@email.com",
                    "type"                => UserModel::TYPE_FULL,
                    "canChangeOperations" => false,
                ]
            ],
            [
                self::TYPE_FULL,
                3,
                [
                    "name"                => "User",
                    "login"               => "user",
                    "email"               => "user@email.com",
                    "type"                => UserModel::TYPE_LIMITED,
                    "canChangeOperations" => true,
                    "operations"          => [
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
                                            "name"  => "operations.SECTIONS.1.SECTION_ADD",
                                            "value" => false
                                        ],
                                        [
                                            "name"  => "operations.SECTIONS.1.SECTION_UPDATE",
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
                                                    "value" => false
                                                ],
                                                [
                                                    "name"  => "operations.BLOCKS.1.ALL.TEXT_UPDATE_SETTINGS",
                                                    "value" => false
                                                ]
                                            ]
                                        ],
                                        1              => [
                                            "title" => "Simple text",
                                            "data"  => [
                                                [
                                                    "name"  => "operations.BLOCKS.1.1.TEXT_ADD",
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
                                    "name"  => "operations.SETTINGS.SETTINGS_ICON",
                                    "value" => true
                                ],
                                [
                                    "name"  => "operations.SETTINGS.SETTINGS_USER_VIEW",
                                    "value" => false
                                ],
                            ]
                        ],
                    ]
                ]
            ],
            [
                self::TYPE_LIMITED,
                1,
                [],
                true
            ],
            [
                self::TYPE_LIMITED,
                2,
                [],
                true
            ],
            [
                self::TYPE_LIMITED,
                3,
                [
                    "name"                => "User",
                    "login"               => "user",
                    "email"               => "user@email.com",
                    "type"                => UserModel::TYPE_LIMITED,
                    "canChangeOperations" => false,
                ]
            ]
        ];
    }

    /**
     * Test for method addUser
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
    public function testAddUser(
        $user,
        $data,
        $hasException,
        $expectedErrors = null,
        $isSuccess = false,
        $expectedOperations = null
    ) {
        $this->setUser($user);
        $this->sendRequest("user", "user", $data, "PUT");

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
            0 => [
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
            1 => [
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
            2 => [
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
            3 => [
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
            4 => [
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
            5 => [
                self::TYPE_FULL,
                [
                    "name"            => "Name",
                    "login"           => "newLogin",
                    "password"        => $password1,
                    "type"            => UserModel::TYPE_LIMITED,
                    "email"           => "newEmail@email.com",
                    "operations"      => []
                ],
                true
            ],
            6 => [
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
            7 => [
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
            8 => [
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
            9 => [
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
                                Operation::SECTION_ADD,
                                Operation::SECTION_UPDATE,
                                "incorrect"
                            ],
                            1 => [
                                Operation::SECTION_DESIGN_UPDATE,
                                "incorrect"
                            ],
                            "incorrect"
                        ],
                        Operation::TYPE_BLOCKS => [
                            BlockModel::TYPE_TEXT => [
                                Operation::ALL => [
                                    Operation::TEXT_ADD,
                                    Operation::TEXT_DELETE,
                                    "incorrect"
                                ],
                                1 => [
                                    Operation::TEXT_DUPLICATE,
                                    "incorrect"
                                ],
                                "incorrect"
                            ],
                            "incorrect"
                        ],
                        Operation::TYPE_SETTINGS => [
                            Operation::SETTINGS_ICON,
                            Operation::SETTINGS_USER_VIEW,
                            "incorrect"
                        ],
                        "incorrect"
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
                        1 => [
                            Operation::SECTION_DESIGN_UPDATE
                        ]
                    ],
                    Operation::TYPE_BLOCKS => [
                        BlockModel::TYPE_TEXT => [
                            Operation::ALL => [
                                Operation::TEXT_ADD,
                                Operation::TEXT_DELETE,
                            ],
                            1 => [
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
                                Operation::SECTION_DESIGN_UPDATE,
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
                                    Operation::TEXT_DUPLICATE
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
    ) {
        $this->setUser($user);

        $model = null;
        if (array_key_exists("id", $data)
            && $data["id"] === "new"
        ) {
            $model = new UserModel();
            $model->set([
                "name"     => "Name",
                "login"    => "newLogin",
                "password" => UserModel::getPasswordHash("pass", true),
                "type"     => UserModel::TYPE_LIMITED,
                "email"    => "newEmail@email.com",
            ]);
            $model->save();

            $data["id"] = $model->getId();
        }

        $this->sendRequest("user", "user", $data, "POST");

        if ($hasException === true) {
            if ($model !== null) {
                $model->delete();
            }

            $this->assertError();
            return true;
        }

        $actual = $this->getBody();
        var_dump($actual);



//        if ($isSuccess === true) {
//            $this->compareExpectedAndActual(
//                [
//                    "result" => true,
//                    "users"  => [
//                        "title" => "Users"
//                    ]
//                ],
//                $actual
//            );
//
//            $model = (new UserModel())->latest()->find();
//
//            if ($expectedOperations !== null) {
//                $this->compareExpectedAndActual($expectedOperations, $model->getOperations(), true);
//            }
//
//            $model->delete();
//        } else {
//            $this->compareExpectedAndActual($expectedErrors, $actual, true);
//        }

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
            0 => [
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
            1 => [
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
            2 => [
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
            3 => [
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
            4 => [
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
            5 => [
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
            6 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "email"            => "newEmail@email.com",
                    "isChangePassword" => true,
                    "operations"       => []
                ],
                true
            ],
            7 => [
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
            8 => [
                self::TYPE_FULL,
                [
                    "id"               => "new",
                    "name"             => "Name",
                    "login"            => "newLogin",
                    "password"         => $password1,
                    "passwordConfirm"  => $password1,
                    "type"             => UserModel::TYPE_LIMITED,
                    "email"            => "newEmail@email.com",
                    "operations"       => []
                ],
                true
            ],
            9 => [
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
                ],
                true
            ],
//            10 => [
//                self::TYPE_FULL,
//                [
//                    "id"               => "new",
//                    "name"             => "Name",
//                    "login"            => "newLogin",
//                    "password"         => $password1,
//                    "passwordConfirm"  => $password1,
//                    "type"             => UserModel::TYPE_LIMITED,
//                    "email"            => "newEmail@email.com",
//                    "isChangePassword" => true,
//                    "operations"       => []
//                ],
//                true
//            ],
        ];
    }

    public function testDeleteUser()
    {
        $this->markTestSkipped();
    }
}