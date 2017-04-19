<?php

namespace testS\tests\unit\models;

use testS\models\UserSessionModel;

/**
 * Tests for the model UserSessionModel
 *
 * @package testS\tests\unit\models
 */
class UserSessionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSessionModel
     */
    protected function getNewModel()
    {
        return new UserSessionModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "token" => ["required", "minLength"],
                    "ip"    => ["required", "ip"]
                ]
            ],
            "empty2" => [
                [
                    "userId"       => "",
                    "token"        => "",
                    "ip"           => "",
                    "ua"           => "",
                    "lastActivity" => ""
                ],
                [
                    "token" => ["required", "minLength"],
                    "ip"    => ["required", "ip"]
                ]
            ],
            "empty3" => [
                [
                    "token" => self::TOKEN_LIMITED,
                ],
                [
                    "ip" => ["required", "ip"]
                ]
            ],
            "empty4" => [
                [
                    "ip" => "127.0.0.1",
                ],
                [
                    "token" => ["required", "minLength"],
                ]
            ],
            "empty5" => [
                [
                    "token" => self::TOKEN_LIMITED,
                    "ip"    => "127.0.0.1",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        $token = $this->generateStringWithLength(32);

        return [
            "correct1" => [
                [
                    "userId" => 1,
                    "token"  => $token,
                    "ip"     => "127.0.0.1",
                    "ua"     => self::UA_FIREFOX_4_0_1,
                ],
                [
                    "userId"       => 1,
                    "token"        => $token,
                    "ip"           => "127.0.0.1",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => date("Y-m-d H:i:s")
                ],
                [
                    "ip" => "127.0.0.2",
                    "ua" => self::UA_CHROME_53_0,
                ],
                [
                    "userId"       => 1,
                    "token"        => $token,
                    "ip"           => "127.0.0.2",
                    "ua"           => self::UA_CHROME_53_0,
                    "lastActivity" => date("Y-m-d H:i:s")
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        $token1 = $this->generateStringWithLength(32);
        $token2 = $this->generateStringWithLength(32);
        $token3 = $this->generateStringWithLength(32);

        return [
            // Duplicated token
            "incorrect1" => [
                [
                    "userId" => 1,
                    "token"  => "c4ca4238a0b923820dcc509a6f75849b",
                    "ip"     => "127.0.0.1",
                    "ua"     => self::UA_FIREFOX_4_0_1,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            // User doesn't exist
            "incorrect2" => [
                [
                    "userId" => 999,
                    "token"  => $token1,
                    "ip"     => "127.0.0.1",
                    "ua"     => self::UA_FIREFOX_4_0_1,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            // Incorrect updating
            "incorrect3" => [
                [
                    "userId"       => "1",
                    "token"        => $token2,
                    "ip"           => "127.0.0.1",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => "2015-01-01 10:11:12"
                ],
                [
                    "userId"       => 1,
                    "token"        => $token2,
                    "ip"           => "127.0.0.1",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => date("Y-m-d H:i:s")
                ],
                [
                    "userId"       => 2,
                    "token"        => $token3,
                    "lastActivity" => "2016-01-01 10:12:11"
                ],
                [
                    "userId"       => 1,
                    "token"        => $token2,
                    "lastActivity" => date("Y-m-d H:i:s")
                ],
            ],
            // Incorrect small token
            "incorrect4" => [
                [
                    "userId" => 1,
                    "token"  => "smalltoken",
                    "ip"     => "127.0.0.1",
                ],
                [
                    "token" => ["minLength"]
                ]
            ],
            // Incorrect big token
            "incorrect5" => [
                [
                    "userId" => 1,
                    "token"  => "big_token_big_token_big_token_big_token_big_token_big_token_",
                    "ip"     => "127.0.0.1",
                ],
                [
                    "token" => ["maxLength"]
                ]
            ],
            // Incorrect ip
            "incorrect6" => [
                [
                    "userId"       => "1",
                    "token"        => $token3,
                    "ip"           => "127.0.1",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => "2015-01-01 10:11:12"
                ],
                [
                    "ip" => ["ip"]
                ]
            ],
            "incorrect7" => [
                [
                    "userId"       => "1",
                    "token"        => $token3,
                    "ip"           => "127.0.0.1",
                    "ua"           => new \stdClass(),
                    "lastActivity" => ["value" => "123"]
                ],
                [
                    "userId"       => 1,
                    "token"        => $token3,
                    "ip"           => "127.0.0.1",
                    "ua"           => "",
                    "lastActivity" => date("Y-m-d H:i:s")
                ]
            ],
            "incorrect8" => [
                [
                    "userId"       => "  1   ",
                    "token"        => "   {$token2}  ",
                    "ip"           => "    127.0.0.1    ",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => "   2015-01-01 10:11:12   "
                ],
                [
                    "userId"       => 1,
                    "token"        => $token2,
                    "ip"           => "127.0.0.1",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => date("Y-m-d H:i:s")
                ],
                [
                    "userId"       => "  incorrect ",
                    "token"        => "   token  ",
                    "ip"           => "    127.0.0.2    ",
                ],
                [
                    "userId"       => 1,
                    "token"        => $token2,
                    "ip"           => "127.0.0.2",
                    "ua"           => self::UA_FIREFOX_4_0_1,
                    "lastActivity" => date("Y-m-d H:i:s")
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * Unable to duplicate. Token must be unique
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "userId"       => 1,
                "token"        => $this->generateStringWithLength(32),
                "ip"           => "127.0.0.1",
                "ua"           => self::UA_FIREFOX_4_0_1,
                "lastActivity" => date("Y-m-d H:i:s")
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }

    /**
     * Test find by token
     *
     * @param string   $token
     * @param int|null $expectedUserId
     *
     * @dataProvider dataProviderForTestByToken
     */
    public function testByToken($token, $expectedUserId)
    {
        $model = $this->getNewModel()->byToken($token)->find();
        if ($expectedUserId === null) {
            $this->assertNull($model);
        } else {
            $this->assertSame($expectedUserId, $model->get("userId"));
        }
    }

    /**
     * Data provider for testByToken
     *
     * @return array
     */
    public function dataProviderForTestByToken()
    {
        return [
            1 => [
                "c4ca4238a0b923820dcc509a6f75849b",
                1
            ],
            2 => [
                "c81e728d9d4c2f636f067f89cc14862c",
                2
            ],
            3 => [
                "eccbc87e4b5ce2fe28308fd9f2a7baf3",
                3
            ],
            4 => [
                $this->generateStringWithLength(32),
                null
            ],
            5 => [
                "incorrect",
                null
            ],
            6 => [
                "",
                null
            ],
            7 => [
                null,
                null
            ]
        ];
    }
}