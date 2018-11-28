<?php

namespace ss\application\instances;

use ss\application\App;

use ss\application\components\user\User;
use ss\application\instances\_abstract\AbstractAjax;
use ss\controllers\page\AdsController;
use ss\controllers\page\FaviconController;
use ss\controllers\page\RobotsController;
use ss\controllers\page\SiteMapController;
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
     * Aliases
     */
    const ALIAS_LOGIN = 'login';
    const ALIAS_SITEMAP = 'sitemap.xml';
    const ALIAS_ROBOTS = 'robots.txt';
    const ALIAS_ADS = 'ads.txt';
    const ALIAS_FAVICON = 'favicon.ico';

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

        if (filter_var($httpHost, FILTER_VALIDATE_IP) !== false) {
            exit;
        }

        $this->setSite($httpHost);
        $this->_setUserAndDb();

        $isAjax = false;
        if (strpos($this->getSite()->getUri(), self::API_PREFIX) === 0) {
            $isAjax = true;
        }

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
        if ($isAjax === false) {
            return $this->processPage();
        }

        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        if ($method !== self::METHOD_GET
            && $this->_user !== null
        ) {
            App::getInstance()->getDb()->beginTransaction(
                $this->getSite()->getWriteDbName()
            );
        }

        return $this->processAjax();
    }

    /**
     * Gets user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
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
        return $this;
    }

    /**
     * Initial user set
     *
     * @return Web
     */
    private function _setUserAndDb()
    {
        $token = $this->_getToken();
        if ($token === null) {
            $this->getDb()->setActivePdoKey(
                $this->getSite()->getReadDbName()
            );
            return $this;
        }

        $this->getDb()->setActivePdoKey(
            $this->getSite()->getWriteDbName()
        );

        $userSessionModel = new UserSessionModel();
        $userSessionModel->byToken($token);
        $userSessionModel = $userSessionModel->find();
        if ($userSessionModel instanceof UserSessionModel === false) {
            $this->getDb()->setActivePdoKey(
                $this->getSite()->getReadDbName()
            );
            return $this;
        }

        $userModel = new UserModel();
        $userModel = $userModel
            ->byId($userSessionModel->get('userId'))
            ->find();
        if ($userModel instanceof UserModel === false) {
            $this->getDb()->setActivePdoKey(
                $this->getSite()->getReadDbName()
            );
            return $this;
        }

        $userSessionModel
            ->set(['lastActivity' => new \DateTime()])
            ->save();

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
        $alias = $this->getSite()->getUri(0);

        switch ($alias) {
            case self::ALIAS_SITEMAP:
                $this->setActiveLanguage(true);
                $controller = new SiteMapController();
                return $controller->run();
            case self::ALIAS_ROBOTS:
                $this->setActiveLanguage(true);
                $controller = new RobotsController();
                return $controller->run();
            case self::ALIAS_ADS:
                $this->setActiveLanguage(true);
                $controller = new AdsController();
                return $controller->run();
            case self::ALIAS_FAVICON:
                $this->setActiveLanguage(true);
                $controller = new FaviconController();
                return $controller->run();
            case self::ALIAS_LOGIN:
                $this->setActiveLanguage(true);
                $controller = new LoginController();
                return $controller->run();
            default:
                break;
        }

        $this->setActiveLanguage();

        if ($this->getSite()->getUri(1) === self::ALIAS_LOGIN
        ) {
            $loginController = new LoginController();
            return $loginController->run();
        }

        $pageController = new PageController();
        return $pageController->run();
    }
}
