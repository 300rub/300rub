<?php

namespace testS\controllers\user;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\components\User;
use testS\application\exceptions\AccessException;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\user\UserModel;
use testS\models\user\UserSessionModel;

/**
 * Removes user session / Logout
 *
 * Removes DB record and Memcache
 *
 * 1. If there is $data["token"] - remove session by token
 * 2. If $data is empty - remove current session (logout)
 */
class DeleteSessionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @throws AccessException
     *
     * @return array
     */
    public function run()
    {
        $user = App::web()->getUser();
        if ($user instanceof User === false) {
            return $this->getSimpleSuccessResult();
        }

        if (empty($this->get('token')) !== false) {
            App::web()->getMemcached()->delete($user->getToken());

            setcookie('token', '', (time() - 3600), '/');
            App::web()
                ->getSuperGlobalVariable()
                ->deleteCookieValue('token');

            $userSessionModel = new UserSessionModel();
            $userSessionModel->byToken($user->getToken());
            $userSessionModel = $userSessionModel->find();
            if ($userSessionModel instanceof UserSessionModel) {
                $userSessionModel->delete();
            }

            return $this->getSimpleSuccessResult();
        }

        $token = $this->_getToken();

        $owner = new UserModel();
        $owner->owner();
        $owner = $owner->find();
        $userSessionModel = new UserSessionModel();
        $userSessionModel->byToken($token);
        $userSessionModel = $userSessionModel->find();

        if ($userSessionModel->get('userId') !== $user->getId()) {
            $this->checkSettingsOperation(
                Operation::SETTINGS_USER_DELETE_SESSIONS
            );
        }

        if ($userSessionModel instanceof UserSessionModel) {
            if ($owner->getId() === $userSessionModel->get('userId')
                && $user->isOwner() === false
            ) {
                throw new AccessException(
                    "Unable to delete owner's session"
                );
            }

            App::web()->getMemcached()->delete($token);
            $userSessionModel->delete();
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets token
     *
     * @return string
     *
     * @throws BadRequestException
     */
    private function _getToken()
    {
        $token = $this->get('token');

        if (is_string($token) === false
            || strlen($token) !== 32
        ) {
            throw new BadRequestException(
                'Incorrect token: {token} to delete UserSession',
                [
                    'token' => $token
                ]
            );
        }

        return $token;
    }
}
