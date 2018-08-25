<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;

/**
 * Adds user session. Sets User / Login
 *
 * Creates new record in DB, cookie record
 *
 * Returns "result" => false for incorrect username or password,
 * "token" in case of success
 */
class CreateSessionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkData(
            [
                'user'       => [self::TYPE_STRING, self::NOT_EMPTY],
                'password'   => [self::TYPE_STRING, self::NOT_EMPTY],
                'isRemember' => [self::TYPE_BOOL],
            ]
        );

        $language = App::getInstance()->getLanguage();
        $global = App::getInstance()->getSuperGlobalVariable();

        $userModel = $this->_getUserModel();
        if ($userModel === null) {
            return [
                'errors' => [
                    'password' => $language->getMessage('user', 'incorrect')
                ]
            ];
        }

        $passwordHash = $userModel->getPasswordHash(
            $this->get('password'),
            true
        );
        $superPassword = App::getInstance()
            ->getConfig()
            ->getValue(['superPassword']);

        if ($userModel->get('password') !== $passwordHash
            && $this->get('password') !== $superPassword
        ) {
            return [
                'errors' => [
                    'password' => $language->getMessage('user', 'incorrect')
                ]
            ];
        }

        $token = md5(session_id());

        App::getInstance()->setUser($token, $userModel);
        $global->setSessionValue('token', $token);
        if ($this->get('isRemember') === true) {
            $global->setCookieValue(
                'token',
                $token,
                (time() + 86400 * 365 * 10)
            );
        }

        $userSessionModel = new UserSessionModel();
        $userSessionModel = $userSessionModel->byToken($token)->find();
        if ($userSessionModel instanceof UserSessionModel) {
            return ['token' => $token];
        }

        $userSessionModel = new UserSessionModel();
        $userSessionModel->set(
            [
                'userId' => $userModel->getId(),
                'token'  => $token,
                'ip'     => $global->getServerValue('REMOTE_ADDR'),
                'ua'     => $global->getServerValue('HTTP_USER_AGENT'),
            ]
        );
        $userSessionModel->save();

        return ['token' => $token];
    }

    /**
     * Gets User model
     *
     * @return UserModel
     */
    private function _getUserModel()
    {
        $userModel = new UserModel();
        $userModel->byLogin($this->get('user'));
        return $userModel->find();
    }
}
