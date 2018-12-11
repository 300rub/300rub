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
        if (count($images) === 0) {
            return '';
        }

        switch ($this->get('type')) {
            case self::TYPE_SLIDER:
                return $this->_getSliderHtml($images);
            case self::TYPE_SIMPLE:
                return $this->_getSimpleHtml($images);
            default:
                return $this->_getZoomHtml($images);
        }
    }

    /**
     * Gets zoom images HTML
     *
     * @param ImageInstanceModel[]|array $images Image Instances
     *
     * @return string
     */
    private function _getZoomHtml($images)
    {
        $content = '';

        foreach ($images as $image) {
            $content .= App::getInstance()->getView()->get(
                'content/image/zoom',
                [
                    'groupId'  => $image->get('imageGroupId'),
                    'alt'      => $image->get('alt'),
                    'viewUrl'  => $image->get('viewFileModel')->getUrl(),
                    'thumbUrl' => $image->get('thumbFileModel')->getUrl(),
                ]
            );
        }

        return $content;
    }

    /**
     * Gets simple images HTML
     *
     * @param ImageInstanceModel[]|array $images Image Instances
     *
     * @return string
     */
    private function _getSimpleHtml($images)
    {
        $content = '';

        foreach ($images as $image) {
            $design = $this->get('designImageSimpleModel');

            $content .= App::getInstance()->getView()->get(
                'content/image/simple',
                [
                    'align'          => $design->getAlignmentValue(),
                    'useDescription' => $design->get('useDescription'),
                    'alt'            => $image->get('alt'),
                    'link'           => $image->get('link'),
                    'viewUrl'
                                     => $image->get('viewFileModel')->getUrl(),
                ]
            );
        }

        return $content;
    }

    /**
     * Gets slider HTML
     *
     * @param ImageInstanceModel[]|array $images Image Instances
     *
     * @return string
     */
    private function _getSliderHtml($images)
    {
        $maxWidth = 100;
        $maxHeight = 100;

        $width = $this->get('viewCropX');
        $height = $this->get('viewCropY');

        $imagesContent = '';
        foreach ($images as $image) {
            $imagesContent .= App::getInstance()->getView()->get(
                'content/image/sliderImage',
                [
                    'link'    => $image->get('link'),
                    'viewUrl' => $image->get('viewFileModel')->getUrl(),
                    'alt'     => $image->get('alt'),
                ]
            );

            if ($image->get('width') > $maxWidth) {
                $maxWidth = $image->get('width');
            }

            if ($image->get('height') > $maxHeight) {
                $maxHeight = $image->get('height');
            }
        }

        if ($width === 0
            || $height === 0
        ) {
            $width = $maxWidth;
            $height = $maxHeight;
        }

        return App::getInstance()->getView()->get(
            'content/image/slider',
            [
                'uniqueId'      => uniqid(),
                'width'         => $width,
                'height'        => $height,
                'imagesContent' => $imagesContent,
            ]
        );
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
                $design = $this->get('designImageSliderModel');

                $jsList = array_merge(
                    $jsList,
                    $view->generateJs(
                        'content/image/js/slider',
                        $container,
                        [
                            'hasAutoPlay'  => $design->get('hasAutoPlay'),
                            'playSpeed'    => $design->get('playSpeed'),
                            'effectValues' => $design->getEffectValues(),
                            'isFullWidth'  => $design->get('isFullWidth'),
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

            $hasCover = false;
            $alt = '';
            $coverUrl = '';
            $image = $album->getCover();
            if ($image !== null) {
                $hasCover = true;
                $alt = $image->get('alt');
                $coverUrl = $image->get('thumbFileModel')->getUrl();
            }

            $content .= App::getInstance()->getView()->get(
                'content/image/album',
                [
                    'hasCover' => $hasCover,
                    'coverUrl' => $coverUrl,
                    'alt'      => $alt,
                    'uri'      => $link->generateLink(
                        $album->get('seoModel')->get('alias')
                    ),
                    'count'    => $album->getCount(),
                    'name'     => $album->get('seoModel')->get('name'),
                ]
            );
        }

        return App::getInstance()->getView()->get(
            'content/block/block',
            [
                'blockId' => $this->getBlockId(),
                'content' => $content
            ]
        );
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
}
