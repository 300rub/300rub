<?php

namespace ss\models\blocks\menu\_content;

use ss\application\App;
use ss\models\blocks\menu\_base\AbstractMenuModel;
use ss\models\blocks\menu\MenuInstanceModel;

/**
 * Abstract model for working menu content
 */
abstract class AbstractContentMenuModel extends AbstractMenuModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\menu\\MenuModel';

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        return App::getInstance()->getView()->get(
            'content/menu/menu',
            [
                'blockId'         => $this->getBlockId(),
                'type'            => $this->getTypeForCssClass(),
                'designMenuModel' => $this->get('designMenuModel'),
                'tree'            => MenuInstanceModel::model()
                    ->getTreeByMenuId($this->getId()),
            ]
        );
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
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
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
