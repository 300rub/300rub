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
        // Send request
        $this->sendRequest("user", "session", $data, "PUT", null, null);

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