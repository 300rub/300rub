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
        $css = [];
        $view = App::getInstance()->getView();

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get('designBlockModel'),
                sprintf('.block-%s', $this->getBlockId())
            )
        );

        if ($this->get('useAlbums') === true) {
            $css = array_merge(
                $css,
                $this->_getAlbumCss()
            );

            return $css;
        }

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                $css = array_merge(
                    $css,
                    $this->_getSliderCss()
                );
                break;
            case self::TYPE_SIMPLE:
                $css = array_merge(
                    $css,
                    $this->_getSimpleCss()
                );
                break;
            default:
                $css = array_merge(
                    $css,
                    $this->_getZoomCss()
                );
                break;
        }

        return $css;
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        $jsList = [];
        $view = App::getInstance()->getView();

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                $jsList = array_merge(
                    $jsList,
                    $view->generateJs(
                        'content/image/js/slider',
                        $this->getBlockId(),
                        [
                            'design'  => $this
                            ->get('designImageSliderModel')
                        ]
                    )
                );
                break;
            case self::TYPE_SIMPLE:
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
     * Gets album design CSS
     *
     * @return array
     */
    private function _getAlbumCss()
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageAlbumModel');
        $blockId = $this->getBlockId();

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('containerDesignBlockModel'),
                sprintf('.block-%s .album .image-container', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('imageDesignBlockModel'),
                sprintf('.block-%s .album .image-container .image', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('nameDesignBlockModel'),
                sprintf('.block-%s .album .image-container .name', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('nameDesignTextModel'),
                sprintf('.block-%s .album .image-container .name', $blockId)
            )
        );

        return $css;
    }


    /**
     * Gets simple design CSS
     *
     * @return array
     */
    private function _getSimpleCss()
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageSimpleModel');
        $blockId = $this->getBlockId();

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('containerDesignBlockModel'),
                sprintf('.block-%s .image-container', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('imageDesignBlockModel'),
                sprintf('.block-%s .image-container .image', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignBlockModel'),
                sprintf('.block-%s .image-container .description', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignTextModel'),
                sprintf('.block-%s .image-container .description', $blockId)
            )
        );

        return $css;
    }

    /**
     * Gets slider design CSS
     *
     * @return array
     */
    private function _getSliderCss()
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageSliderModel');
        $blockId = $this->getBlockId();

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('arrowDesignTextModel'),
                sprintf('.block-%s .arrow i', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('bulletDesignBlockModel'),
                sprintf('.block-%s .i .bullet', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('bulletActiveDesignBlockModel'),
                sprintf('.block-%s .iav .bullet', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignBlockModel'),
                sprintf('.block-%s .description', $blockId)
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('descriptionDesignTextModel'),
                sprintf('.block-%s .description', $blockId)
            )
        );

        return $css;
    }

    /**
     * Gets zoom design CSS
     *
     * @return array
     */
    private function _getZoomCss()
    {
        $css = [];
        $view = App::getInstance()->getView();
        $design = $this->get('designImageZoomModel');
        $blockId = $this->getBlockId();

        $css = array_merge(
            $css,
            $view->generateCss(
                $design->get('designBlockModel'),
                sprintf('.block-%s .image-container', $blockId)
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
