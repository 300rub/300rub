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
     * Cache eky mask
     */
    const CACHE_KEY_MASK = 'images_%s_html_%s';

    /**
     * Current album
     *
     * @var ImageGroupModel
     */
    private $_currentAlbum = false;

    /**
     * Gets HTML memcached key
     *
     * @return string
     */
    private function _getMemcachedKey()
    {
        $site = App::getInstance()->getSite();
        $uri = '';
        if ($site !== null) {
            $uri = $site->getUri(2);
        }

        return sprintf(
            self::CACHE_KEY_MASK,
            $this->getId(),
            $uri
        );
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->_getMemcachedKey();
        $memcachedValue = $memcached->get($memcachedKey);

        if ($memcachedValue !== false) {
            return $memcachedValue;
        }

        $html = $this->_getHtml();

        $memcached->set($memcachedKey, $html);

        return $html;
    }

    /**
     * Gets HTML
     *
     * @return string
     */
    private function _getHtml()
    {
        $currentAlbum = $this->_getCurrentAlbum();
        $albumId = 0;

        if ($currentAlbum instanceof ImageGroupModel
            && $this->getContentModel()->get('useAlbums') === true
        ) {
            $albumId = $currentAlbum->getId();
        }

        if ($albumId === 0
            && $this->getContentModel()->get('useAlbums') === true
        ) {
            return $this->_getImageGroupsHtml();
        }

        return $this->_getImageInstancesHtml($albumId);
    }

    /**
     * Gets albums HTML
     *
     * @return string
     */
    private function _getImageGroupsHtml()
    {
        $albums = ImageGroupModel::model()->findAllByImageId(
            $this->getContentId()
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
                        ->withRelations()
                        ->find()
                );
        }

        return App::getInstance()->getView()->get(
            'content/image/albums',
            [
                'blockId' => $this->getBlockId(),
                'albums'  => $albums
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
    private function _getImageInstancesHtml($albumId)
    {
        $images = new ImageInstanceModel();
        $images
            ->ordered('sort')
            ->withRelations();

        if ($albumId === 0) {
            $images->byImageId($this->getContentId());
        }

        if ($albumId > 0) {
            $images->byGroupId($albumId);
        }

        $images = $images->findAll();

        switch ($this->getContentModel()->get('type')) {
            case self::TYPE_SLIDER:
                return App::getInstance()->getView()->get(
                    'content/image/slider',
                    [
                        'blockId' => $this->getBlockId(),
                        'images'  => $images
                    ]
                );
            case self::TYPE_SIMPLE:
                return App::getInstance()->getView()->get(
                    'content/image/simple',
                    [
                        'blockId' => $this->getBlockId(),
                        'images'  => $images,
                        'design'  => $this
                            ->getContentModel()
                            ->get('designImageSimpleModel')
                    ]
                );
            default:
                return App::getInstance()->getView()->get(
                    'content/image/zoom',
                    [
                        'blockId' => $this->getBlockId(),
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
            ->byImageId($this->getContentId())
            ->byUrl($albumUrl)
            ->withRelations()
            ->find();

        return $this;
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

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                break;
            case self::TYPE_SIMPLE:
                $css = array_merge(
                    $css,
                    $this->_getSimpleDesign()
                );
                break;
            default:
                break;
        }

        return $css;
    }

    /**
     * Gets simple design CSS
     *
     * @return array
     */
    private function _getSimpleDesign()
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
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
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
