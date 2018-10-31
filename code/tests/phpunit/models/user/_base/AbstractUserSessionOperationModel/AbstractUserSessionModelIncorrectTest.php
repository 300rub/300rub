<?php

namespace ss\tests\phpunit\models\user\_base\AbstractUserSessionModel;

use ss\models\user\UserSessionModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserSessionModel
 */
class AbstractUserSessionModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return array_merge(
            $this->_getDataProviderIncorrect1(),
            $this->_getDataProviderIncorrect2()
        );
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect1()
    {
        $token1 = $this->generateStringWithLength(32);
        $token2 = $this->generateStringWithLength(32);
        $token3 = $this->generateStringWithLength(32);

        return [
            'incorrect1' => [
                [
                    'userId' => 1,
                    'token'  => 'c4ca4238a0b923820dcc509a6f75849b',
                    'ip'     => '127.0.0.1',
                    'ua'     => self::UA_FIREFOX_4_0_1,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'userId' => 999,
                    'token'  => $token1,
                    'ip'     => '127.0.0.1',
                    'ua'     => self::UA_FIREFOX_4_0_1,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'userId'       => '1',
                    'token'        => $token2,
                    'ip'           => '127.0.0.1',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                    'lastActivity' => '2015-01-01 10:11:12'
                ],
                [
                    'userId'       => 1,
                    'token'        => $token2,
                    'ip'           => '127.0.0.1',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                ],
                [
                    'userId'       => 2,
                    'token'        => $token3,
                ],
                [
                    'userId'       => 1,
                    'token'        => $token2,
                ],
            ],
            'incorrect4' => [
                [
                    'userId' => 1,
                    'token'  => 'smalltoken',
                    'ip'     => '127.0.0.1',
                ],
                [
                    'token' => ['minLength']
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        $token3 = $this->generateStringWithLength(32);
        $token4 = $this->generateStringWithLength(32);

        return [
            'incorrect5' => [
                [
                    'userId' => 1,
                    'token'  => 'big_token_big_token_big_token' .
                        '_big_token_big_token_big_token_',
                    'ip'     => '127.0.0.1',
                ],
                [
                    'token' => ['maxLength']
                ]
            ],
            'incorrect6' => [
                [
                    'userId'       => '1',
                    'token'        => $token3,
                    'ip'           => '127.0.1',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                    'lastActivity' => '2015-01-01 10:11:12'
                ],
                [
                    'ip' => ['ip']
                ]
            ],
            'incorrect7' => [
                [
                    'userId'       => '1',
                    'token'        => $token3,
                    'ip'           => '127.0.0.1',
                    'ua'           => new \stdClass(),
                    'lastActivity' => ['value' => '123']
                ],
                [
                    'userId'       => 1,
                    'token'        => $token3,
                    'ip'           => '127.0.0.1',
                    'ua'           => '',
                ]
            ],
            'incorrect8' => [
                [
                    'userId'       => '  1   ',
                    'token'        => '   ' . $token4 . '  ',
                    'ip'           => '    127.0.0.1    ',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                    'lastActivity' => '   2015-01-01 10:11:12   '
                ],
                [
                    'userId'       => 1,
                    'token'        => $token4,
                    'ip'           => '127.0.0.1',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                ],
                [
                    'userId'       => '  incorrect ',
                    'token'        => '   token  ',
                    'ip'           => '    127.0.0.2    ',
                ],
                [
                    'userId'       => 1,
                    'token'        => $token4,
                    'ip'           => '127.0.0.2',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                ]
            ],
        ];
    }
}
