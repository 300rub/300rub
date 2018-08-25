<?php

namespace ss\tests\phpunit\controllers\user;

use ss\application\App;
use ss\models\user\UserSessionModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller DeleteSessionsController
 */
class DeleteSessionsControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $userId   User ID
     * @param bool   $hasError Error flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $userId = null, $hasError = null)
    {
        $this->setUser($user);

        $sessionsToDelete = new UserSessionModel();
        $sessionsToDelete->byUserId($userId);
        $sessionsToDelete = $sessionsToDelete->findAll();
        foreach ($sessionsToDelete as $sessionModel) {
            $this->assertNotNull($sessionModel);
        }

        $data = [];
        if ($userId !== null) {
            $data = ['id' => $userId];
        }

        $this->sendRequest('user', 'sessions', $data, 'DELETE');

        if ($hasError === true) {
            $this->assertError();

            foreach ($sessionsToDelete as $sessionModel) {
                $userSessionModel = new UserSessionModel();
                $userSessionModel->byId($sessionModel->getId());
                $this->assertNotNull($userSessionModel->find());
            }

            return true;
        }

        foreach ($sessionsToDelete as $sessionModel) {
            if ($sessionModel->get('token') === $this->getUserToken()) {
                $userSessionModel = new UserSessionModel();
                $userSessionModel->byId($sessionModel->getId());
                $this->assertNotNull($userSessionModel->find());

                continue;
            }

            $userSessionModel = new UserSessionModel();
            $userSessionModel->byId($sessionModel->getId());
            $this->assertNull($userSessionModel->find());

            $sessionModel->clearId()->save();
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
            'ownerDeleteOwner'     => [
                self::TYPE_OWNER,
                1
            ],
            'ownerDeleteHimself'   => [
                self::TYPE_OWNER
            ],
            'ownerDeleteAdmin'     => [
                self::TYPE_OWNER,
                2
            ],
            'ownerDeleteUser'      => [
                self::TYPE_OWNER,
                3
            ],
            'adminDeleteOwner'     => [
                self::TYPE_FULL,
                1,
                true
            ],
            'adminDeleteHimself'   => [
                self::TYPE_OWNER
            ],
            'adminDeleteAdmin'     => [
                self::TYPE_OWNER,
                2
            ],
            'adminDeleteUser'      => [
                self::TYPE_OWNER,
                3
            ],
            'limitedDeleteOwner'   => [
                self::TYPE_LIMITED,
                1,
                true
            ],
            'limitedDeleteHimself' => [
                self::TYPE_LIMITED
            ],
            'limitedDeleteAdmin'   => [
                self::TYPE_LIMITED,
                2,
                true
            ],
            'limitedDeleteUser'    => [
                self::TYPE_LIMITED,
                3
            ],
        ];
    }
}
