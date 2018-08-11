<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\help\CategoryModel;

/**
 * HelpController to work with help pages
 */
class HelpController extends AbstractController
{

    /**
     * Gets site help
     *
     * @return string
     */
    public function run()
    {
        $language = App::getInstance()->getLanguage();

        $model = CategoryModel::model()
            ->setAlias('sections')
            ->setContent();

        $pageHtml = $this->getPageHtml(
            $this->_getContent(),
            $language->getMessage('site', 'helpTitle'),
            $language->getMessage('site', 'helpKeywords'),
            $language->getMessage('site', 'helpDescription')
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
                'uri'      => sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
                'label'    => $language->getMessage('site', 'home'),
                'isActive' => false
            ],
            [
                'uri'      => sprintf(
                    '/%s/help',
                    $language->getActiveAlias()
                ),
                'label'    => $language->getMessage('site', 'help'),
                'isActive' => true
            ]
        ];

        return $this->getContentFromTemplate(
            'site/help',
            [
                'menu' => $menu
            ]
        );
    }
}
