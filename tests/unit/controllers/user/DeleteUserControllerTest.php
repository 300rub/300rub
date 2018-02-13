<?php

namespace ss\tests\unit\controllers\user;

use ss\models\user\UserModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteUserController
 */
class DeleteUserControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param bool   $hasError Error flag
     *
     * @dataProvider dataProvider
     *
     * @return void
     */
    public function testRun($user, $hasError = null)
    {
        $newUser = new UserModel();
        $newUser->set(
            [
                'login'    => $this->generateStringWithLength(7),
                'password' => $this->generateStringWithLength(40),
                'type'     => UserModel::TYPE_FULL,
                'name'     => $this->generateStringWithLength(10),
                'email'    => $this->generateStringWithLength(7) . '@email.com',
            ]
        );
        $newUser->save();
        $newUserId = $newUser->getId();

        $newUser = new UserModel();
        $newUser->byId($newUserId);
        $newUser = $newUser->find();
        $this->assertNotNull($newUser);

        $this->setUser($user);
        $this->sendRequest(
            'user',
            'user',
            [
                'id' => $newUser->getId()
            ],
            'DELETE'
        );

        if ($hasError === true) {
            $newUser->delete();
            $this->assertError();
        }

        if ($hasError !== true) {
            $this->assertSame(
                [
                    'result' => true
                ],
                $this->getBody()
            );
        }

        $newUser = new UserModel();
        $newUser->byId($newUser->getId());
        $newUser = $newUser->find();
        $this->assertNull($newUser);

        // Unable to remove owner.
        $this->sendRequest('user', 'user', ['id' => 1], 'DELETE');
        $this->assertError();
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                self::TYPE_FULL
            ],
            [
                self::TYPE_OWNER
            ],
            [
                self::TYPE_LIMITED,
                true
            ],
            [
                self::TYPE_BLOCKED_USER,
                true
            ],
        ];
    }
}
