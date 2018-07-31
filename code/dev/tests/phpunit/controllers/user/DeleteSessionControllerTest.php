<?php

namespace ss\tests\phpunit\controllers\user;

use ss\application\App;
use ss\models\_abstract\AbstractModel;
use ss\models\user\UserSessionModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteSessionController
 */
class DeleteSessionControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param string $token    Token
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($user, $token = null, $hasError = null)
    {
        $memcached = App::getInstance()->getMemcached();
        $this->setUser($user);

        $beforeDelete = new UserSessionModel();
        $beforeDelete = $beforeDelete->getCount();

        $sessionModel = $this->_sendRequest($token);

        $afterDelete = new UserSessionModel();
        $afterDelete = $afterDelete->getCount();

        if ($hasError === true) {
            $this->assertError();
            $this->assertSame($beforeDelete, $afterDelete);
            return true;
        }

        $this->assertSame(($beforeDelete - 1), $afterDelete);
        $sessionModel->clearId()->save();

        $this->assertArrayHasKey('host', $this->getBody());

        $memcachedResult = $memcached->get($sessionModel->get('token'));
        $this->assertFalse($memcachedResult);

        return true;
    }

    /**
     * Sends request
     *
     * @param string $token Token
     *
     * @return UserSessionModel|AbstractModel
     */
    private function _sendRequest($token)
    {
        if ($token !== null) {
            $sessionModel = new UserSessionModel();
            $sessionModel->byToken($token);
            $sessionModel = $sessionModel->find();
            $this->sendRequest(
                'user',
                'session',
                [
                    'token' => $token
                ],
                'DELETE'
            );

            return $sessionModel;
        }

        $sessionModel = new UserSessionModel();
        $sessionModel->byToken($this->getUserToken());
        $sessionModel = $sessionModel->find();
        $this->sendRequest(
            'user',
            'session',
            [],
            'DELETE'
        );

        return $sessionModel;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'ownerDeleteOwner'     => [
                self::TYPE_OWNER,
                'c4ca4238a0b923820dcc509a6f75849b'
            ],
            'ownerDeleteHimself'   => [
                self::TYPE_OWNER
            ],
            'ownerDeleteAdmin'     => [
                self::TYPE_OWNER,
                'c81e728d9d4c2f636f067f89cc14862c'
            ],
            'ownerDeleteUser'      => [
                self::TYPE_OWNER,
                'eccbc87e4b5ce2fe28308fd9f2a7baf3'
            ],
            'adminDeleteOwner'     => [
                self::TYPE_FULL,
                'c4ca4238a0b923820dcc509a6f75849b',
                true
            ],
            'adminDeleteHimself'   => [
                self::TYPE_OWNER
            ],
            'adminDeleteAdmin'     => [
                self::TYPE_OWNER,
                'c81e728d9d4c2f636f067f89cc14862c',
            ],
            'adminDeleteUser'      => [
                self::TYPE_OWNER,
                'eccbc87e4b5ce2fe28308fd9f2a7baf3',
            ],
            'limitedDeleteOwner'   => [
                self::TYPE_LIMITED,
                'c4ca4238a0b923820dcc509a6f75849b',
                true
            ],
            'limitedDeleteHimself' => [
                self::TYPE_LIMITED
            ],
            'limitedDeleteAdmin'   => [
                self::TYPE_LIMITED,
                'c81e728d9d4c2f636f067f89cc14862c',
                true
            ],
            'limitedDeleteUser'    => [
                self::TYPE_LIMITED,
                'eccbc87e4b5ce2fe28308fd9f2a7baf3'
            ],
        ];
    }
}
