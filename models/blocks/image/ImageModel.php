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
     * Gets HTML memcached key
     *
     * @return string
     */
    public function getHtmlMemcachedKey()
    {
        return $this->_getMemcachedKey('html');
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    public function getCssMemcachedKey()
    {
        return $this->_getMemcachedKey('css');
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    public function getJsMemcachedKey()
    {
        return $this->_getMemcachedKey('js');
    }

    /**
     * Gets Memcached key
     *
     * @param string $type Type
     *
     * @return string
     */
    private function _getMemcachedKey($type)
    {
        $site = App::getInstance()->getSite();
        $uri = '';
        if ($site !== null) {
            $uri = $site->getUri(2);
        }

        return sprintf(
            'image_%s_%s_%s',
            $this->getId(),
            $type,
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
        $htmlMemcachedKey = $this->getHtmlMemcachedKey();
        $htmlMemcachedValue = $memcached->get($htmlMemcachedKey);

        if ($htmlMemcachedValue !== false) {
            return $htmlMemcachedValue;
        }

        $html = $this->_getHtml();

        $memcached->set($htmlMemcachedKey, $html);

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
            return $this->_getImageGroupHtml();
        }

        return $this->_getImageInstanceHtml($albumId);
    }

    /**
     * Gets albums HTML
     *
     * @return string
     */
    private function _getImageGroupHtml()
    {
        $albums = ImageGroupModel::model()->findAllByImageId(
            $this->getContentId()
        );

        foreach ($albums as &$album) {
            $album->setCount(
                ImageInstanceModel::model()
                    ->byGroupId($album->getId())
                    ->getCount()
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
    private function _getImageInstanceHtml($albumId)
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
                $view = 'slider';
                break;
            case self::TYPE_SIMPLE:
                $view = 'simple';
                break;
            default:
                $view = 'zoom';
                break;
        }

        return App::getInstance()->getView()->get(
            sprintf('content/image/%s', $view),
            [
                'blockId' => $this->getBlockId(),
                'images'  => $images
            ]
        );
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
        return [];
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
}
