<?php

namespace ss\tests\phpunit\controllers\user;

use ss\application\App;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateSessionController
 */
class CreateSessionControllerTest extends AbstractControllerTest
{

    /**
     * Test for creating session
     *
     * @param array $data         Data
     * @param int   $expectedCode Expected code
     * @param array $expectedBody Expected body
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun(
        $data,
        $expectedCode = 200,
        $expectedBody = null
    ) {
        $this->setUser(null);

        // Send request.
        $this->sendRequest('user', 'session', $data, 'POST');

        // Check status code.
        $this->assertSame($expectedCode, $this->getStatusCode());
        if ($expectedCode !== 200) {
            return true;
        }

        $actualBody = $this->getBody();

        // Check error response.
        if ($expectedBody !== null) {
            $this->compareExpectedAndActual($expectedBody, $actualBody, true);
            return true;
        }

        // Getting record by token from response.
        $this->assertTrue(count($actualBody) === 1);
        $token = $actualBody['token'];
        $userSessionModel = new UserSessionModel();
        $userSessionModel->byToken($token);
        $userSessionModel = $userSessionModel->find();
        $this->assertNotNull($userSessionModel);

        $isIgnoreCache = App::getInstance()
            ->getConfig()
            ->getValue(['memcached', 'isIgnoreCache']);

        // Make sure that logged User stores in memcache.
        $memcached = App::getInstance()->getMemcached();
        if ($isIgnoreCache !== true) {
            $user = $memcached->get($token);
            $this->assertInstanceOf(
                'ss\\application\\components\\User',
                $user
            );
        }

        // Check cookies.
        $sessionIdFromCookie = $this->getSessionIdFromCookie();
        $this->assertSame(md5($sessionIdFromCookie), $token);
        $tokenFromCookie = $this->getTokenFromCookie();
        if ($data['isRemember'] === true) {
            $this->assertSame($tokenFromCookie, $token);
        }

        if ($data['isRemember'] !== true
            && $tokenFromCookie !== 'deleted'
        ) {
            $this->assertNull($tokenFromCookie);
        }

        // Remove.
        $userSessionModel->delete();
        if ($isIgnoreCache !== true) {
            $memcached->delete($token);
        }

        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'emptyData'               => [
                'data' => [],
                400
            ],
            'emptyDataFields'         => [
                'data' => [
                    'user'       => '',
                    'password'   => '',
                    'isRemember' => '',
                ],
                400
            ],
            'incorrectTypeUser'       => [
                'data' => [
                    'user'       => 1,
                    'password'   => md5('pass' . UserModel::PASSWORD_SALT),
                    'isRemember' => false,
                ],
                400
            ],
            'incorrectTypePassword'   => [
                'data' => [
                    'user'       => 'user',
                    'password'   => 1,
                    'isRemember' => false,
                ],
                400
            ],
            'incorrectTypeIsRemember' => [
                'data' => [
                    'user'       => 'user',
                    'password'   => md5('pass' . UserModel::PASSWORD_SALT),
                    'isRemember' => 1,
                ],
                400
            ],
            'incorrectUser'           => [
                'data' => [
                    'user'       => 'incorrect',
                    'password'   => md5('pass' . UserModel::PASSWORD_SALT),
                    'isRemember' => false,
                ],
                200,
                [
                    'errors' => [
                        'user' => 'Incorrect user or password'
                    ]
                ]
            ],
            'incorrectPassword'       => [
                'data' => [
                    'user'       => 'user',
                    'password'   => md5('incorrect' . UserModel::PASSWORD_SALT),
                    'isRemember' => false,
                ],
                200,
                [
                    'errors' => [
                        'password' => 'Incorrect user or password'
                    ]
                ]
            ],
            'user'                    => [
                'data' => [
                    'user'       => 'user',
                    'password'   => md5('pass' . UserModel::PASSWORD_SALT),
                    'isRemember' => false,
                ],
                200
            ],
            'admin'                   => [
                'data' => [
                    'user'       => 'admin',
                    'password'   => md5('pass' . UserModel::PASSWORD_SALT),
                    'isRemember' => true,
                ],
                200
            ],
        ];
    }
}
