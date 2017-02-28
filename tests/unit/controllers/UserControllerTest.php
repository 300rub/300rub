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

    public function testGetsSessions()
    {
        $this->markTestSkipped();
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