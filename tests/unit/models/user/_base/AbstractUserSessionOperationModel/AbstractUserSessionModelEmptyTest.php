<?php

namespace testS\tests\unit\models\user\_base\AbstractUserSessionModel;

use testS\models\user\UserSessionModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserSessionModel
 */
class AbstractUserSessionModelEmptyTest extends AbstractEmptyModelTest
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
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'token' => ['required', 'minLength'],
                    'ip'    => ['required', 'ip']
                ]
            ],
            'empty2' => [
                [
                    'userId'       => '',
                    'token'        => '',
                    'ip'           => '',
                    'ua'           => '',
                    'lastActivity' => ''
                ],
                [
                    'token' => ['required', 'minLength'],
                    'ip'    => ['required', 'ip']
                ]
            ],
            'empty3' => [
                [
                    'token' => self::TOKEN_LIMITED,
                ],
                [
                    'ip' => ['required', 'ip']
                ]
            ],
            'empty4' => [
                [
                    'ip' => '127.0.0.1',
                ],
                [
                    'token' => ['required', 'minLength'],
                ]
            ],
            'empty5' => [
                [
                    'token' => self::TOKEN_LIMITED,
                    'ip'    => '127.0.0.1',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ]
        ];
    }
}
