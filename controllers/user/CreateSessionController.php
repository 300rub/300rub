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
 * Creates new record in DB, memcached record, cookie record
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

        $language = App::web()->getLanguage();
        $global = App::web()->getSuperGlobalVariable();

        $userModel = new UserModel();
        $userModel->byLogin($this->get('user'));
        $userModel = $userModel->find();
        if ($userModel instanceof UserModel === false) {
            return [
                'errors' => [
                    'user' => $language->getMessage('user', 'incorrect')
                ]
            ];
        }

        if ($userModel->get('password') !== sha1($this->get('password'))) {
            return [
                'errors' => [
                    'password' => $language->getMessage('user', 'incorrect')
                ]
            ];
        }

        $token = md5(session_id());

        App::web()->setUser($token, $userModel);
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
}
