<?php

namespace ss\models\blocks\image;

use ss\application\App;
use ss\models\blocks\image\_base\AbstractImageModel;

/**
 * Model for working with table "images"
 */
class ImageModel extends AbstractImageModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\image\\ImageModel';

    /**
     * Current album
     *
     * @var ImageGroupModel
     */
    private $_currentAlbum = false;

    /**
     * Gets cache type
     *
     * @return integer
     */
    public function getCacheType()
    {
        return self::CACHED_BY_URI;
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

        if ($currentAlbum instanceof ImageGroupModel
            && $this->get('useAlbums') === true
        ) {
            $albumId = $currentAlbum->getId();
        }

        if ($albumId === 0
            && $this->get('useAlbums') === true
        ) {
            return $this->_getImageGroupsHtml();
        }

        return App::getInstance()->getView()->get(
            'content/block/block',
            [
                'blockId' => $this->getBlockId(),
                'content' => $this->getImageInstancesHtml($albumId)
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
     * Gets albums HTML
     *
     * @return string
     */
    private function _getImageGroupsHtml()
    {
        $albums = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );

        foreach ($albums as &$album) {
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
        }

        $content = App::getInstance()->getView()->get(
            'content/image/albums',
            [
                'albums'  => $albums
            ]
        );

        return App::getInstance()->getView()->get(
            'content/block/block',
            [
                'blockId' => $this->getBlockId(),
                'content' => $content
            ]
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
     * Gets current album
     *
     * @return null|ImageGroupModel
     */
    private function _getCurrentAlbum()
    {
        if ($this->_currentAlbum === false) {
            $this->_setCurrentAlbum();
        }

        return $this->_currentAlbum;
    }

    /**
     * Sets album model from URL
     *
     * @return ImageModel
     */
    private function _setCurrentAlbum()
    {
        $albumUrl = App::getInstance()->getSite()->getUri(2);
        if ($albumUrl === null) {
            return null;
        }

        $this->_currentAlbum = ImageGroupModel::model()
            ->byImageId($this->getId())
            ->byUrl($albumUrl)
            ->find();

        return $this;
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
     * Gets ImageModel
     *
     * @return ImageModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        $imageGroups = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );
        foreach ($imageGroups as $imageGroup) {
            $imageGroup->resetMemcached();
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
        $imageGroups = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );
        foreach ($imageGroups as $imageGroup) {
            $imageGroup->delete();
        }

        parent::beforeDelete();
    }
}
