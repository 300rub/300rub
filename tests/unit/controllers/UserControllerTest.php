<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
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
     * Test for adding session
     *
     * @param array $data
     * @param int   $expectedCode
     * @param bool  $isSuccess
     *
     * @dataProvider dataProviderForTestAddSSession
     *
     * @return bool
     */
    public function testAddSession($data, $expectedCode = 200, $isSuccess = false)
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
        if ($isSuccess === false) {
            $expectedBody = [
                "result" => false
            ];
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
            $this->assertNull($tokenFromCookie);
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
                ]
            ],
            "incorrectPassword"       => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("incorrect" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ]
            ],
            "user"                    => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ],
                200,
                true
            ],
            "admin"                   => [
                "data" => [
                    "user"       => "admin",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => true,
                ],
                200,
                true
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
                self::TYPE_ADMIN,
                "",
                "",
                true
            ],
            "user"     => [
                self::TYPE_USER,
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
     * @param string $userType
     * @param string $tokenToCreate
     * @param string $tokenToDelete
     * @param bool   $isRemoved
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestDeleteSessionByToken
     */
    public function testDeleteSessionByToken($userType, $tokenToCreate, $tokenToDelete, $isRemoved, $hasError)
    {
        $this->setUser($userType);

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
            "ownerSuccess" => [
                self::TYPE_OWNER,
                $token,
                $token,
                true,
                false
            ],
            "tokenNotExist" => [
                self::TYPE_OWNER,
                $token,
                $this->generateStringWithLength(32),
                false,
                false
            ],
            "anotherUserToken" => [
                self::TYPE_OWNER,
                $token,
                self::TOKEN_ADMIN,
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

    public function testDeleteSessions()
    {
        $this->markTestSkipped();
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