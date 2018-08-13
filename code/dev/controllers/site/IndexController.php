<?php

namespace ss\controllers\site;

use ss\application\App;
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
        $language = App::getInstance()->getLanguage();

        $menu = [
            [
                'uri'  => sprintf(
                    '/%s/help',
                    $language->getActiveAlias()
                ),
                'name' => $language->getMessage('site', 'help')
            ]
        ];

        return $this->getContentFromTemplate(
            'site/index',
            [
                'menu' => $menu
            ]
        );
    }
}
