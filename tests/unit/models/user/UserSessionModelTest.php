<?php

namespace ss\tests\unit\models\user;

use ss\models\user\UserSessionModel;
use ss\tests\unit\models\_abstract\AbstractModelTest;

/**
 * Tests for the model UserSessionModel
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
     * Test find by token
     *
     * @param string   $token          Token
     * @param int|null $expectedUserId Expected user ID
     *
     * @dataProvider dataProviderForTestByToken
     *
     * @return UserSessionModelTest
     */
    public function testByToken($token, $expectedUserId)
    {
        $model = $this->getNewModel()->byToken($token)->find();
        if ($expectedUserId === null) {
            $this->assertNull($model);
            return $this;
        }

        $this->assertSame($expectedUserId, $model->get('userId'));
        return $this;
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
                'c4ca4238a0b923820dcc509a6f75849b',
                1
            ],
            2 => [
                'c81e728d9d4c2f636f067f89cc14862c',
                2
            ],
            3 => [
                'eccbc87e4b5ce2fe28308fd9f2a7baf3',
                3
            ],
            4 => [
                $this->generateStringWithLength(32),
                null
            ],
            5 => [
                'incorrect',
                null
            ],
            6 => [
                '',
                null
            ],
            7 => [
                null,
                null
            ]
        ];
    }
}
