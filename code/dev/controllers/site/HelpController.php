<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\controllers\site\_abstract\AbstractController;
use ss\models\help\_abstract\AbstractModel;
use ss\models\help\CategoryModel;
use ss\models\help\PageModel;

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

        $requestUri = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $uriArray = explode('/', trim($requestUri, '/'));

        if (count($uriArray) < 3) {
            return $this->getPageHtml(
                $this->_getContent(),
                $language->getMessage('site', 'helpTitle'),
                $language->getMessage('site', 'helpKeywords'),
                $language->getMessage('site', 'helpDescription')
            );
        }

//        if (array_keys(3, $uriArray) === false) {
//            $categoryModel = CategoryModel::model()
//                ->setAlias($uriArray[2])
//                ->setContent();
//
//            return $this->getPageHtml(
//                $this->_getContent($categoryModel),
//                $categoryModel->getTitle(),
//                $categoryModel->getKeywords(),
//                $categoryModel->getDescription()
//            );
//        }
//
//        $pageModel = PageModel::model()
//            ->setAlias($uriArray[3])
//            ->setContent();
//
//        return $this->getPageHtml(
//            $this->_getContent($pageModel),
//            $pageModel->getTitle(),
//            $pageModel->getKeywords(),
//            $pageModel->getDescription()
//        );
    }

    /**
     * Gets content
     *
     * @return string
     */
    private function _getContent()
    {
        $language = App::getInstance()->getLanguage();

        return $this->getContentFromTemplate(
            'site/helpCategory',
            [
                'menu' => $this->_getMenuHtml(),
                'name' =>  $language->getMessage('site', 'help'),
                'text' =>  $language->getMessage('site', 'helpText'),
                'childCategories'
                    => CategoryModel::model()->getChildCategories()
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
            'site/menu',
            [
                'menu' => $menu
            ]
        );
    }
}
