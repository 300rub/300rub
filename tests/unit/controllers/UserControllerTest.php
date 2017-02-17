<?php

namespace testS\tests\unit\controllers;

use testS\models\UserModel;

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
     * @param array $expectedBody
     *
     * @dataProvider dataProviderForTestAddSSession
     *
     * @return bool
     */
    public function testAddSession($data, $expectedCode = 200, $expectedBody = null)
    {
        $this->sendRequest("user", "session", $data, "PUT", null, null);

        $this->assertSame($expectedCode, $this->getStatusCode());

        if ($expectedCode !== 200) {
            return true;
        }

        if ($expectedBody !== null) {
            $this->compareExpectedAndActual($expectedBody, $this->getBody(), true);
        }

        /**
         * @TODO
         * - Проверить куки что там есть ид сессии и токен
         * - Сравнить ид сессии и токен (мд5)
         * - Тест с куками и без
         * - Чтение записи из таблицы сессий
         * - Чтение из мемкэша
         * - Ручное удаление кэша, кук и записи в БД
         */

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
                    "result" => false
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
                    "result" => false
                ]
            ],
            "user"                    => [
                "data" => [
                    "user"       => "user",
                    "password"   => md5("pass" . UserModel::PASSWORD_SALT),
                    "isRemember" => false,
                ]
            ],
        ];
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