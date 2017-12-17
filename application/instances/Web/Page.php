<?php

namespace testS\application\instances;

use testS\application\components\User;
use testS\application\instances\_abstract\AbstractWeb;
use testS\models\UserModel;
use testS\models\UserSessionModel;

/**
 * Class for working with WEB application
 */
class Web extends AbstractWeb
{

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

        try {
            session_start();
            $this->_initialUserSet();

            $output = $this->getOutput($isAjax);
        } catch (\Exception $e) {
            if ($this->useTransaction === true) {
                $this->getDb()->rollbackTransaction();
            }

            $output = $e->getMessage();
            if ($isAjax === true) {
                $output = json_encode(
                    [
                        'error' => [
                            'message' => $e->getMessage(),
                            'file'    => $e->getFile(),
                            'line'    => $e->getLine(),
                            'trace'   => $e->getTraceAsString(),
                        ]
                    ]
                );
            }

            switch ($e->getCode()) {
                case 204:
                    http_response_code(204);
                    break;
                case 400:
                    http_response_code(400);
                    break;
                case 404:
                    http_response_code(404);
                    break;
                case 403:
                    http_response_code(403);
                    break;
                default:
                    http_response_code(500);
                    break;
            }
        }

        echo $output;
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
        $userSessionModel = $userSessionModel->byToken($token)->find();
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
