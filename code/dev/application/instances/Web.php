<?php

namespace ss\application\instances;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\User;
use ss\application\instances\_abstract\AbstractAjax;
use ss\commands\db\ImportFixturesCommand;
use ss\models\_abstract\AbstractModel;
use ss\models\user\UserModel;
use ss\models\user\UserSessionModel;
use ss\controllers\page\LoginController;
use ss\controllers\page\PageController;

/**
 * Class for working with WEB application
 */
class Web extends AbstractAjax
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

        $this->setSite($httpHost);

        $isAjax = false;
        if (strpos($this->getSite()->getUri(), self::API_PREFIX) === 0) {
            $isAjax = true;
        }

        $this
            ->_initialUserSet()
            ->_setAdminDb();

        echo $this->_getOutput($isAjax);
    }

    /**
     * Sets Admin Db
     *
     * @return Web
     */
    private function _setAdminDb()
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this;
        }

        $token = $user->getToken();
        if ($token === ImportFixturesCommand::FIXTURES_TOKEN) {
            return $this;
        }

        $siteModel = $this->getSite();
        $dbName =  $siteModel->get('dbName');
        $phpunitDbName = $this
            ->getConfig()
            ->getValue(['db', 'phpunit', 'name']);
        if ($dbName === $phpunitDbName) {
            return $this;
        }

        $this->getDb()->setConnection(
            Db::CONNECTION_TYPE_ADMIN,
            $siteModel->get('dbHost'),
            $siteModel->get('dbUser'),
            $siteModel->get('dbPassword'),
            $this->getDb()->getAdminDbName(
                $siteModel->get('dbName')
            )
        );

        $this->getDb()->setCurrentConnection(Db::CONNECTION_TYPE_ADMIN);

        return $this;
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
     * @param string                  $token     Token
     * @param UserModel|AbstractModel $userModel User model
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
        $input = $this->getInput();
        if (empty($input['token']) === false) {
            $this
                ->getSuperGlobalVariable()
                ->setSessionValue('token', $input['token'])
                ->setCookieValue('token', $input['token']);
            return $input['token'];
        }

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

        return null;
    }

    /**
     * Gets Page output
     *
     * @return string
     */
    protected function processPage()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $requestUri = strtolower(trim($requestUri, '/'));

        if ($requestUri === 'login') {
            $loginController = new LoginController();
            return $loginController->run();
        }

        $requestParameters = explode('/', $requestUri);
        if (count($requestParameters) > 1
            && $requestParameters[1] === LoginController::LOGIN_ALIAS
        ) {
            App::getInstance()
                ->getLanguage()
                ->setIdByAlias($requestParameters[0]);

            $loginController = new LoginController();
            return $loginController->run();
        }

        $pageController = new PageController();
        return $pageController->run();
    }
}
