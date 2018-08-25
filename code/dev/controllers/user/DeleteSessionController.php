<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\components\user\User;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;

/**
 * Removes user session / Logout
 *
 * Removes DB record
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
        $user = App::getInstance()->getUser();
        if ($user instanceof User === false) {
            return $this->getSimpleSuccessResult();
        }

        $token = $this->get('token');
        if (empty($token) !== false) {
            setcookie('token', '', (time() - 3600), '/');
            App::getInstance()
                ->getSuperGlobalVariable()
                ->deleteCookieValue('token');

            $userSessionModel = new UserSessionModel();
            $userSessionModel->byToken($user->getToken());
            $userSessionModel = $userSessionModel->find();
            if ($userSessionModel instanceof UserSessionModel) {
                $userSessionModel->delete();
            }

            return $this->_getResponse();
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

            $userSessionModel->delete();
        }

        return $this->_getResponse();
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

    /**
     * Gets response
     *
     * @return array
     */
    private function _getResponse()
    {
        return [
            'host' => $this->generateAbsoluteUrl(
                '',
                App::getInstance()->getSite()->getMainHost(),
                self::PROTOCOL_HTTP
            )
        ];
    }
}
