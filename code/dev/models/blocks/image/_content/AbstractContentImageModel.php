<?php

namespace ss\models\blocks\image\_content;

use ss\application\App;
use ss\application\components\helpers\Link;
use ss\models\blocks\image\_base\AbstractImageModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Abstract model for working with images content
 */
abstract class AbstractContentImageModel extends AbstractImageModel
{

    /**
     * Gets cache key
     *
     * @param int $albumId Album ID
     *
     * @return string
     */
    public function getHtmlMemcachedKey($albumId)
    {
        return sprintf('image_%s_%s_html', $this->getId(), $albumId);
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $currentAlbum = $this->_getCurrentAlbum();
        $albumId = 0;

        if ($this->get('useAlbums') === true) {
            if ($currentAlbum === null) {
                return $this->_getImageGroupsHtml();
            }

            $albumId = $currentAlbum->getId();
        }

        $cacheValue = $this->getHtmlMemcached(
            $this->getHtmlMemcachedKey($albumId)
        );
        if ($cacheValue !== false) {
            return $cacheValue;
        }

        $html = App::getInstance()->getView()->get(
            'content/block/block',
            [
                'blockId' => $this->getBlockId(),
                'content' => $this->getImageInstancesHtml($albumId)
            ]
        );

        $this->setHtmlMemcached(
            $this->getHtmlMemcachedKey($albumId),
            $html
        );

        return $html;
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        return $this->generateCssForContainer(
            sprintf('.block-%s', $this->getBlockId())
        );
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return $this->generateJsForContainer(
            sprintf('.block-%s', $this->getBlockId())
        );
    }

    /**
     * Gets images HTML
     *
     * @param int $albumId Album ID
     *
     * @return string
     */
    public function getImageInstancesHtml($albumId)
    {
        $images = new ImageInstanceModel();
        $images->ordered('sort');

        if ($albumId === 0) {
            $images->byImageId($this->getId());
        }

        if ($albumId > 0) {
            $images->byGroupId($albumId);
        }

        $images = $images->findAll();

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                return App::getInstance()->getView()->get(
                    'content/image/slider',
                    [
                        'images'  => $images,
                        'image'   => $this,
                    ]
                );
            case self::TYPE_SIMPLE:
                return App::getInstance()->getView()->get(
                    'content/image/simple',
                    [
                        'images'  => $images,
                        'design'  => $this->get('designImageSimpleModel')
                    ]
                );
            default:
                return App::getInstance()->getView()->get(
                    'content/image/zoom',
                    [
                        'images'  => $images
                    ]
                );
        }
    }

    /**
     * Generates CSS for container
     *
     * @param string $container CSS container
     *
     * @return array
     */
    public function generateCssForContainer($container)
    {
        $css = [];
        $view = App::getInstance()->getView();

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get('designBlockModel'),
                $container
            )
        );

        if ($this->get('useAlbums') === true) {
            $css = array_merge(
                $css,
                $this->_getAlbumCss($container)
            );

            return $css;
        }

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                $css = array_merge(
                    $css,
                    $this->_getSliderCss($container)
                );
                break;
            case self::TYPE_SIMPLE:
                $css = array_merge(
                    $css,
                    $this->_getSimpleCss($container)
                );
                break;
            default:
                $css = array_merge(
                    $css,
                    $this->_getZoomCss($container)
                );
                break;
        }

        return $css;
    }

    /**
     * Generates JS
     *
     * @param string $container CSS selector container
     *
     * @return array
     */
    public function generateJsForContainer($container)
    {
        $jsList = [];
        $view = App::getInstance()->getView();

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                $jsList = array_merge(
                    $jsList,
                    $view->generateJs(
                        'content/image/js/slider',
                        $container,
                        [
                            'design' => $this
                                ->get('designImageSliderModel')
                        ]
                    )
                );
                break;
            default:
                break;
        }

        return $jsList;
    }

    /**
     * Gets current album
     *
     * @return null|ImageGroupModel
     */
    private function _getCurrentAlbum()
    {
        $albumAlias = App::getInstance()->getSite()->getUri(2);
        if ($albumAlias === null) {
            return null;
        }

        return ImageGroupModel::model()
            ->byImageId($this->getId())
            ->byAlias($albumAlias)
            ->find();
    }

    /**
     * Gets albums HTML
     *
     * @return string
     */
    private function _getImageGroupsHtml()
    {
        $cacheValue = $this->getHtmlMemcached(
            $this->getHtmlMemcachedKey(-1)
        );
        if ($cacheValue !== false) {
            return $cacheValue;
        }

        $content = '';
        $link = new Link();

        $albums = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );
        foreach ($albums as $album) {
            $album
                ->setCount(
                    ImageInstanceModel::model()
                        ->byGroupId($album->getId())
                        ->getCount()
                )
                ->setCover(
                    ImageInstanceModel::model()
                        ->coverByGroupId($album->getId())
                        ->find()
                );

            $content .= App::getInstance()->getView()->get(
                'content/image/album',
                [
                    'album' => $album,
                    'url'   => $link->generateLink(
                        $album->get('seoModel')->get('alias')
                    )
                ]
            );
        }

        $html = App::getInstance()->getView()->get(
            'content/block/block',
            [
                'blockId' => $this->getBlockId(),
                'content' => $content
            ]
        );

        $this->setHtmlMemcached(
            $this->getHtmlMemcachedKey(-1),
            $html
        );

        return $html;
    }

    /**
     * Gets album design CSS
     *
     * @param string $container CSS container
     *
     * @return array
     */
    private function _getAlbumCss($container)
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageAlbumModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('containerDesignBlockModel'),
                sprintf('%s .album .image-container', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('imageDesignBlockModel'),
                sprintf('%s .album .image-container .image', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('nameDesignBlockModel'),
                sprintf('%s .album .image-container .name', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('nameDesignTextModel'),
                sprintf('%s .album .image-container .name', $container)
            )
        );

        return $css;
    }


    /**
     * Gets simple design CSS
     *
     * @param string $container CSS container
     *
     * @return array
     */
    private function _getSimpleCss($container)
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageSimpleModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('containerDesignBlockModel'),
                sprintf('%s .image-container', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('imageDesignBlockModel'),
                sprintf('%s .image-container .image', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignBlockModel'),
                sprintf('%s .image-container .description', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignTextModel'),
                sprintf('%s .image-container .description', $container)
            )
        );

        return $css;
    }

    /**
     * Gets slider design CSS
     *
     * @param string $container CSS container
     *
     * @return array
     */
    private function _getSliderCss($container)
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageSliderModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('arrowDesignTextModel'),
                sprintf('%s .arrow i', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('bulletDesignBlockModel'),
                sprintf('%s .i .bullet', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('bulletActiveDesignBlockModel'),
                sprintf('%s .iav .bullet', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignBlockModel'),
                sprintf('%s .description', $container)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignTextModel'),
                sprintf('%s .description', $container)
            )
        );

        return $css;
    }

    /**
     * Gets zoom design CSS
     *
     * @param string $container CSS container
     *
     * @return array
     */
    private function _getZoomCss($container)
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageZoomModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('designBlockModel'),
                sprintf('%s .image-container', $container)
            )
        );

        return $css;
    }

    /**
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        $this
            ->deleteHtmlMemcached(
                $this->getHtmlMemcachedKey(0)
            )
            ->deleteHtmlMemcached(
                $this->getHtmlMemcachedKey(-1)
            );

        $imageGroups = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );
        foreach ($imageGroups as $imageGroup) {
            $this->deleteHtmlMemcached(
                $this->getHtmlMemcachedKey($imageGroup->getId())
            );
        }

        parent::beforeSave();
    }

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
        $this
            ->deleteHtmlMemcached(
                $this->getHtmlMemcachedKey(0)
            )
            ->deleteHtmlMemcached(
                $this->getHtmlMemcachedKey(-1)
            );

        parent::beforeDelete();
    }
}
