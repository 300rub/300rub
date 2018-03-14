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
     * Gets HTML memcached key
     *
     * @return string
     */
    public function getHtmlMemcachedKey()
    {
        return sprintf('image_%s_html', $this->getId());
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    public function getCssMemcachedKey()
    {
        return sprintf('image_%s_css', $this->getId());
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    public function getJsMemcachedKey()
    {
        return sprintf('image_%s_js', $this->getId());
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

//        $html = App::getInstance()->getView()->get(
//            'content/image/zoom',
//            [
//                'blockId' => $this->getBlockId(),
//                'images'  => ImageInstanceModel::model()
//                    ->byImageId($this->getContentId())
//                    ->ordered('sort')
//                    ->withRelations()
//                    ->findAll()
//            ]
//        );

        $html = App::getInstance()->getView()->get(
            'content/image/slider',
            [
                'blockId' => $this->getBlockId(),
                'images'  => ImageInstanceModel::model()
                    ->byImageId($this->getContentId())
                    ->ordered('sort')
                    ->withRelations()
                    ->findAll()
            ]
        );

        $memcached->set($htmlMemcachedKey, $html);

        return $html;
    }

    private function _getAlbumFromUri()
    {
        $albumUrl = App::getInstance()->getSite()->getUri(2);
        if ($albumUrl === null) {
            return null;
        }
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
