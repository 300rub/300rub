<?php

namespace testS\tests\unit\models\user\_base\AbstractUserSessionModel;

use testS\models\user\UserSessionModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserSessionModel
 */
class AbstractUserSessionModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        $token = $this->generateStringWithLength(32);

        return [
            'correct1' => [
                [
                    'userId' => 1,
                    'token'  => $token,
                    'ip'     => '127.0.0.1',
                    'ua'     => self::UA_FIREFOX_4_0_1,
                ],
                [
                    'userId'       => 1,
                    'token'        => $token,
                    'ip'           => '127.0.0.1',
                    'ua'           => self::UA_FIREFOX_4_0_1,
                ],
                [
                    'ip' => '127.0.0.2',
                    'ua' => self::UA_CHROME_53_0,
                ],
                [
                    'userId'       => 1,
                    'token'        => $token,
                    'ip'           => '127.0.0.2',
                    'ua'           => self::UA_CHROME_53_0,
                ],
            ],
        ];
    }
}
