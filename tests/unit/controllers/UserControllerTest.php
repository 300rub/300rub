<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
use testS\components\User;
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
                        "user"    => [
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
                        "password" => [
                            "name"       => "password",
                            "type"       => "password",
                            "label"      => "Password",
                            "validation" => [
                                "required"  => "required",
                                "minLength" => 3,
                                "maxLength" => 40,
                            ]
                        ],
                        "isRemember"    => [
                            "name"  => "isRemember",
                            "type"  => "checkbox",
                            "label" => "Remember me",
                        ],
                        "button"   => [
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
            //$this->compareExpectedAndActual($expected, $this->getBody(), true);
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
                [],
                true
            ],
            [
                self::TYPE_FULL,
                [
                    "list" => [
                        [
                            "name"       => "Icon",
                            "email" => "settings",
                            "type"     => "icon",
                        ]
                    ]
                ]
            ],
        ];
    }

    public function testAddUser()
    {
        $this->markTestSkipped();
    }

    public function testGetUser()
    {
        $this->markTestSkipped();
    }

    public function testUpdateUser()
    {
        $this->markTestSkipped();
    }

    public function testDeleteUser()
    {
        $this->markTestSkipped();
    }
}