<?php

namespace ss\models\blocks\menu;

use ss\application\App;
use ss\models\blocks\menu\_base\AbstractMenuModel;

/**
 * Model for working with table "menu"
 */
class MenuModel extends AbstractMenuModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\menu\\MenuModel';

    /**
     * Gets HTML memcached key
     *
     * @return string
     */
    public function getHtmlMemcachedKey()
    {
        return sprintf('menu_%s_html', $this->getId());
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    public function getCssMemcachedKey()
    {
        return sprintf('menu_%s_css', $this->getId());
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    public function getJsMemcachedKey()
    {
        return sprintf('menu_%s_js', $this->getId());
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $memcached = App::getInstance()->getMemcached();
        $htmlMemcachedKey = $this->getHtmlMemcachedKey();
        $htmlMemcachedValue = $memcached->get($htmlMemcachedKey);

        if ($htmlMemcachedValue !== false) {
            //return $htmlMemcachedValue;
        }

        $html = App::getInstance()->getView()->get(
            'content/menu/menu',
            [
                'blockId'         => $this->getBlockId(),
                'type'            => $this->getContentModel()->getTypeForCssClass(),
                'designMenuModel' => $this->getContentModel()->get('designMenuModel'),
                'tree'            => MenuInstanceModel::model()->getTreeByMenuId($this->getContentId()),
            ]
        );
        $memcached->set($htmlMemcachedKey, $html);

        return $html;
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $view = App::getInstance()->getView();
        $designModel = $this->get('designMenuModel');

        $css = [];

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('containerDesignBlockModel'),
                sprintf('.block-%s', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $this->_generateFirstLevelCss()
        );

        $css = array_merge(
            $css,
            $this->_generateSecondLevelCss()
        );

        $css = array_merge(
            $css,
            $this->_generateLastLevelCss()
        );

        return $css;
    }

    /**
     * Generates first level CSS
     *
     * @return array
     */
    private function _generateFirstLevelCss()
    {
        $view = App::getInstance()->getView();
        $designModel = $this->get('designMenuModel');

        $css = [];

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('firstLevelDesignBlockModel'),
                sprintf('.block-%s .first-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('firstLevelDesignTextModel'),
                sprintf('.block-%s .first-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('firstLevelActiveDesignBlockModel'),
                sprintf('.block-%s .first-level-active', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('firstLevelActiveDesignTextModel'),
                sprintf('.block-%s .first-level-active', $this->getBlockId())
            )
        );

        return $css;
    }

    /**
     * Generates second level CSS
     *
     * @return array
     */
    private function _generateSecondLevelCss()
    {
        $view = App::getInstance()->getView();
        $designModel = $this->get('designMenuModel');

        $css = [];

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('secondLevelDesignBlockModel'),
                sprintf('.block-%s .second-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('secondLevelDesignTextModel'),
                sprintf('.block-%s .second-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('secondLevelActiveDesignBlockModel'),
                sprintf('.block-%s .second-level-active', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('secondLevelActiveDesignTextModel'),
                sprintf('.block-%s .second-level-active', $this->getBlockId())
            )
        );

        return $css;
    }

    /**
     * Generates last level CSS
     *
     * @return array
     */
    private function _generateLastLevelCss()
    {
        $view = App::getInstance()->getView();
        $designModel = $this->get('designMenuModel');

        $css = [];

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('lastLevelDesignBlockModel'),
                sprintf('.block-%s .last-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('lastLevelDesignTextModel'),
                sprintf('.block-%s .last-level', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('lastLevelActiveDesignBlockModel'),
                sprintf('.block-%s .last-level-active', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designModel->get('lastLevelActiveDesignTextModel'),
                sprintf('.block-%s .last-level-active', $this->getBlockId())
            )
        );

        return $css;
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
    }

    /**
     * Gets MenuModel
     *
     * @return MenuModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets type value for CSS class
     *
     * @return array
     */
    public function getTypeForCssClass()
    {
        switch ($this->get('type')) {
            case self::TYPE_HORIZONTAL:
                return 'horizontal';
            default:
                return 'vertical';
        }
    }
}
