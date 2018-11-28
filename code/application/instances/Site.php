<?php

namespace ss\application\instances;

use ss\application\components\common\Language;
use ss\application\instances\_abstract\AbstractAjax;
use ss\controllers\site\_abstract\AbstractController;
use ss\controllers\site\AdsController;
use ss\controllers\site\CreateController;
use ss\controllers\site\HelpController;
use ss\controllers\site\IndexController;
use ss\controllers\site\RobotsController;
use ss\controllers\site\SiteMapController;

/**
 * Class for working with Site application
 */
class Site extends AbstractAjax
{

    /**
     * Aliases
     */
    const ALIAS_SITEMAP = 'sitemap.xml';
    const ALIAS_ROBOTS = 'robots.txt';
    const ALIAS_ADS = 'ads.txt';
    const ALIAS_HELP = 'help';
    const ALIAS_CREATE = 'create';

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        echo $this->_getOutput($this->_isAjax());
    }

    /**
     * Flag is ajax
     *
     * @return bool
     */
    private function _isAjax()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $requestUri = strtolower(trim($requestUri, '/'));
        $requestParameters = explode('/', $requestUri);

        if ($requestUri === ''
            || count($requestParameters) === 0
        ) {
            return false;
        }

        if ($requestParameters[0] === self::API_PREFIX) {
            return true;
        }

        return false;
    }

    /**
     * Gets controller
     *
     * @return AbstractController
     */
    private function _getPageController()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        $requestUri = trim($requestUri, '/');
        $requestParameters = explode('/', $requestUri);

        if ($requestUri === ''
            || count($requestParameters) === 0
        ) {
            $this->getLanguage()->setActiveId(
                Language::LANGUAGE_RU_ID
            );
            return new IndexController();
        }

        $alias = strtolower($requestParameters[0]);
        switch ($alias) {
            case self::ALIAS_SITEMAP:
                return new SiteMapController();
            case self::ALIAS_ROBOTS:
                return new RobotsController();
            case self::ALIAS_ADS:
                return new AdsController();
            default:
                break;
        }

        $this->getLanguage()->setIdByAlias(
            $requestParameters[0]
        );

        if (count($requestParameters) === 1) {
            return new IndexController();
        }

        $alias = strtolower($requestParameters[1]);

        switch ($alias) {
            case self::ALIAS_HELP:
                return new HelpController();
            case self::ALIAS_CREATE:
                return new CreateController();
            default:
                return new IndexController();
        }
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

        $controller = $this->_getPageController();
        return $controller->run();
    }

    /**
     * Gets user
     *
     * @return mixed
     */
    public function getUser()
    {
        return null;
    }
}
