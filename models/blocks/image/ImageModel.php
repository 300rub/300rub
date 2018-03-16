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
    public function _getMemcachedKey()
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

    /**
     * Runs after saving
     *
     * @return void
     */
    protected function afterSave()
    {
        parent::afterSave();

        $imageGroups = ImageGroupModel::model()->findAllByImageId($this->getId());
        foreach ($imageGroups as $imageGroup) {
            $imageGroup->resetMemcached();
        }
    }

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
        parent::beforeDelete();

        $imageGroups = ImageGroupModel::model()->findAllByImageId($this->getId());
        foreach ($imageGroups as $imageGroup) {
            $imageGroup->delete();
        }
    }
}
