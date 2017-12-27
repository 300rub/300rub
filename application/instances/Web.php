<?php

namespace testS\application\instances;

use testS\application\components\User;
use testS\application\instances\_abstract\AbstractWebAjax;
use testS\models\user\UserModel;
use testS\models\user\UserSessionModel;

/**
 * Class for working with WEB application
 */
class Web extends AbstractWebAjax
{

    /**
     * API url
     */
    const API_URL = 'api';

    /**
     * User in session
     *
     * @var User
     */
    private $_user = null;

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $httpHost = $this
            ->getSuperGlobalVariable()
            ->getServerValue('HTTP_HOST');
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        $this->setSite($httpHost);

        $isAjax = false;
        if (strpos(trim($requestUri, '/'), self::API_URL) === 0) {
            $isAjax = true;
        }

        session_start();

        $this->_initialUserSet();

        echo $this->_getOutput($isAjax);
    }

    /**
     * Gets output
     *
     * @param bool $isAjax Flag of ajax request
     *
     * @return string
     */
    private function _getOutput($isAjax)
    {
        if ($isAjax === true) {
            return $this->processAjax();
        }

        return $this->processPage();
    }

    /**
     * Gets user
     *
     * @return User
     */
    public function getUser()
    {
        if ($this->_user instanceof User) {
            return $this->_user;
        }

        return $this->_initialUserSet()->_user;
    }

    /**
     * Sets User
     *
     * @param string    $token     Token
     * @param UserModel $userModel User model
     *
     * @return Web
     */
    public function setUser($token, UserModel $userModel)
    {
        $this->_user = new User($token, $userModel);

        $this->getMemcached()->set($token, $this->_user);

        return $this;
    }

    /**
     * Initial user set
     *
     * @return Web
     */
    private function _initialUserSet()
    {
        $token = $this->_getToken();
        if ($token === null) {
            return $this;
        }

        $user = $this->getMemcached()->get($token);
        if ($user instanceof User) {
            $this->_user = $user;
            return $this;
        }

        $userSessionModel = new UserSessionModel();
        $userSessionModel->byToken($token);
        $userSessionModel = $userSessionModel->find();
        if ($userSessionModel instanceof UserSessionModel === false) {
            return $this;
        }

        $userModel = new UserModel();
        $userModel = $userModel
            ->byId($userSessionModel->get('userId'))
            ->find();
        if ($userModel instanceof UserModel === false) {
            return $this;
        }

        return $this->setUser($token, $userModel);
    }

    /**
     * Gets token
     *
     * @return string|null
     */
    private function _getToken()
    {
        $sessionToken = $this
            ->getSuperGlobalVariable()
            ->getSessionValue('token');
        if ($sessionToken !== null) {
            return $sessionToken;
        }

        $cookieToken = $this
            ->getSuperGlobalVariable()
            ->getCookieValue('token');
        if ($cookieToken !== null) {
            $this
                ->getSuperGlobalVariable()
                ->setSessionValue('token', $cookieToken);
            return $cookieToken;
        }

        $input = $this->getInput();
        if (empty($input['token']) === false) {
            $this
                ->getSuperGlobalVariable()
                ->setSessionValue('token', $input['token'])
                ->setCookieValue('token', $input['token']);
            return $input['token'];
        }

        return null;
    }
}
