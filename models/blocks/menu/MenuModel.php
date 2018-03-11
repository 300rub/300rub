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
        $css = [];

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
