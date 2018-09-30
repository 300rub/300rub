<?php

namespace ss\controllers\site;

use ss\application\App;
use ss\application\components\db\Db;
use ss\application\instances\Site;
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

        App::getInstance()->getDb()->setActivePdoKey(
            Db::CONFIG_DB_NAME_HELP
        );

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

        if (count($uriArray) < 4) {
            $categoryModel = CategoryModel::model()
                ->setAlias($uriArray[2])
                ->setBaseUri($this->_getUri())
                ->setContent();

            return $this->getPageHtml(
                $this->_getCategoryContent($categoryModel),
                $categoryModel->getTitle(),
                $categoryModel->getKeywords(),
                $categoryModel->getDescription()
            );
        }

        $pageModel = PageModel::model()
            ->setAlias($uriArray[3])
            ->setBaseUri($this->_getUri())
            ->setContent();

        return $this->getPageHtml(
            $this->_getPageContent($pageModel),
            $pageModel->getTitle(),
            $pageModel->getKeywords(),
            $pageModel->getDescription()
        );
    }

    /**
     * Gets content
     *
     * @return string
     */
    private function _getContent()
    {
        $language = App::getInstance()->getLanguage();

        $breadcrumbs = [
            [
                'uri'  => sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
                'name' => $language->getMessage('site', 'home'),
            ],
            [
                'name' => $language->getMessage('site', 'help'),
            ]
        ];

        return $this->render(
            'site/helpCategory',
            [
                'breadcrumbs' => $this->_getBreadCrumbsHtml($breadcrumbs),
                'menu'        => $this->_getMenuHtml(),
                'name'        => $language->getMessage('site', 'help'),
                'text'        => $language->getMessage('site', 'helpText'),
                'childCategories'
                    => CategoryModel::model()
                    ->setBaseUri($this->_getUri())
                    ->getChildCategories(),
                'pages'       => []
            ]
        );
    }

    /**
     * Gets category content
     *
     * @param CategoryModel|AbstractModel $categoryModel Model
     *
     * @return string
     */
    private function _getCategoryContent($categoryModel)
    {
        return $this->render(
            'site/helpCategory',
            [
                'breadcrumbs' => $this->_getBreadCrumbsHtml(
                    $categoryModel->getBreadcrumbs()
                ),
                'menu'        => $this->_getMenuHtml(),
                'name'        => $categoryModel->getName(),
                'text'        => $categoryModel->getText(),
                'childCategories'
                    => CategoryModel::model()
                    ->setBaseUri($this->_getUri())
                    ->getChildCategories(
                        $categoryModel->getAlias()
                    ),
                'pages'       => PageModel::model()
                    ->setBaseUri($this->_getUri())
                    ->getListByCategoryAlias(
                        $categoryModel->getAlias()
                    )
            ]
        );
    }

    /**
     * Gets page content
     *
     * @param PageModel|AbstractModel $pageModel Model
     *
     * @return string
     */
    private function _getPageContent($pageModel)
    {
        return $this->render(
            'site/helpPage',
            [
                'breadcrumbs' => $this->_getBreadCrumbsHtml(
                    $pageModel->getBreadcrumbs()
                ),
                'menu'        => $this->_getMenuHtml(),
                'name'        => $pageModel->getName(),
                'text'        => $pageModel->getText(),
            ]
        );
    }

    /**
     * Gets breadcrumbs HTML
     *
     * @param array $breadcrumbs Breadcrumbs
     *
     * @return string
     */
    private function _getBreadCrumbsHtml($breadcrumbs)
    {
        return $this->render(
            'site/breadcrumbs',
            [
                'breadcrumbs' => $breadcrumbs
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
                'isActive' => false
            ],
            [
                'uri'      => $this->_getUri(),
                'name'     => $language->getMessage('site', 'help'),
                'isActive' => true
            ]
        ];

        return $this->render(
            'site/menu',
            [
                'menu' => $menu
            ]
        );
    }

    /**
     * Gets URI
     *
     * @return string
     */
    private function _getUri()
    {
        return sprintf(
            '/%s/%s',
            App::getInstance()->getLanguage()->getActiveAlias(),
            Site::HELP_PREFIX
        );
    }
}
