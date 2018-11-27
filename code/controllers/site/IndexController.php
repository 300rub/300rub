<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\instances\Site;
use ss\controllers\site\_abstract\AbstractController;

/**
 * IndexController to work with main page
 */
class IndexController extends AbstractController
{

    /**
     * Gets site page
     *
     * @return string
     */
    public function run()
    {
        App::getInstance()->getLogger()->error('Test log');
        App::getInstance()->getLogger()->info('Test log');
        App::getInstance()->getLogger()->warning('Test log');
        App::getInstance()->getLogger()->info('Test log', [], 'create');

        $language = App::getInstance()->getLanguage();

        $pageHtml = $this->getPageHtml(
            $this->_getContent(),
            $language->getMessage('site', 'title'),
            $language->getMessage('site', 'keywords'),
            $language->getMessage('site', 'description')
        );

        return $pageHtml;
    }

    /**
     * Gets content
     *
     * @return string
     */
    private function _getContent()
    {
        return $this->render(
            'site/index',
            [
                'menu' => $this->_getMenuHtml(),
                'name' => App::getInstance()
                    ->getLanguage()
                    ->getMessage('site', 'homeName'),
                'text' => App::getInstance()
                    ->getLanguage()
                    ->getMessage('site', 'homeText')
            ]
        );
    }

    /**
     * Gets menu HTML
     *
     * @return string
     */
    private function _getMenuHtml()
    {
        $language = App::getInstance()->getLanguage();

        $menu = [
            [
                'uri'      => sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
                'name'     => $language->getMessage('site', 'home'),
                'isActive' => true
            ],
            [
                'uri'      => sprintf(
                    '/%s/%s',
                    App::getInstance()->getLanguage()->getActiveAlias(),
                    Site::HELP_PREFIX
                ),
                'name'     => $language->getMessage('site', 'help'),
                'isActive' => false
            ]
        ];

        return $this->render(
            'site/menu',
            [
                'menu' => $menu
            ]
        );
    }
}
