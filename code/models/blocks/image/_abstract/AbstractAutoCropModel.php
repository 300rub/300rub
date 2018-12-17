<?php

namespace ss\models\blocks\image\_abstract;

use Gregwar\Image\Image;
use ss\models\blocks\image\_base\AbstractImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Abstract model to auto crop
 */
abstract class AbstractAutoCropModel extends AbstractImageInstanceModel
{

    /**
     * Auto crops image
     *
     * @param Image $image  Image
     * @param int   $type   Auto crop type
     * @param int   $cropX  Crop X
     * @param int   $cropY  Crop Y
     * @param int   $width  Width
     * @param int   $height Height
     *
     * @return Image
     */
    protected function autoCrop($image, $type, $cropX, $cropY, $width, $height)
    {
        if ($type === ImageModel::AUTO_CROP_TYPE_NONE
            || $cropX === 0
            || $cropY === 0
        ) {
            return $image;
        }

        $aspectRatioCrop = ($cropX / $cropY);
        $aspectRatioImage = ($width / $height);
        if ($aspectRatioCrop === $aspectRatioImage) {
            return $image;
        }

        if ($aspectRatioCrop > $aspectRatioImage) {
            return $this->_autoCropByWidth(
                $image,
                $type,
                $width,
                $height,
                $aspectRatioCrop
            );
        }

        return $this->_autoCropByHeight(
            $image,
            $type,
            $width,
            $height,
            $aspectRatioCrop
        );
    }

    /**
     * Auto crop type by width
     *
     * @param Image $image           Image
     * @param int   $type            Auto crop type
     * @param int   $width           Width
     * @param int   $height          Height
     * @param float $aspectRatioCrop Aspect Ration
     *
     * @return Image
     */
    private function _autoCropByWidth(
        $image,
        $type,
        $width,
        $height,
        $aspectRatioCrop
    ) {
        $resultHeight = ($width / $aspectRatioCrop);

        if ($type === ImageModel::AUTO_CROP_TYPE_TOP_LEFT
            || $type === ImageModel::AUTO_CROP_TYPE_TOP_CENTER
            || $type === ImageModel::AUTO_CROP_TYPE_TOP_RIGHT
        ) {
            return $image->crop(
                0,
                0,
                $width,
                $resultHeight
            );
        }

        if ($type === ImageModel::AUTO_CROP_TYPE_BOTTOM_RIGHT
            || $type === ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER
            || $type === ImageModel::AUTO_CROP_TYPE_BOTTOM_RIGHT
        ) {
            return $image->crop(
                0,
                ($height - $resultHeight),
                $width,
                $resultHeight
            );
        }

        return $image->crop(
            0,
            (($height - $resultHeight) / 2),
            $width,
            $resultHeight
        );
    }

    /**
     * Auto crop type by height
     *
     * @param Image $image           Image
     * @param int   $type            Auto crop type
     * @param int   $width           Width
     * @param int   $height          Height
     * @param float $aspectRatioCrop Aspect Ration
     *
     * @return Image
     */
    private function _autoCropByHeight(
        $image,
        $type,
        $width,
        $height,
        $aspectRatioCrop
    ) {
        $resultWidth = ($height * $aspectRatioCrop);

        if ($type === ImageModel::AUTO_CROP_TYPE_TOP_LEFT
            || $type === ImageModel::AUTO_CROP_TYPE_MIDDLE_LEFT
            || $type === ImageModel::AUTO_CROP_TYPE_BOTTOM_LEFT
        ) {
            return $image->crop(
                0,
                0,
                $resultWidth,
                $height
            );
        }

        if ($type === ImageModel::AUTO_CROP_TYPE_TOP_RIGHT
            || $type === ImageModel::AUTO_CROP_TYPE_MIDDLE_RIGHT
            || $type === ImageModel::AUTO_CROP_TYPE_BOTTOM_RIGHT
        ) {
            return $image->crop(
                ($width - $resultWidth),
                0,
                $resultWidth,
                $height
            );
        }

        return $image->crop(
            (($width - $resultWidth) / 2),
            0,
            $resultWidth,
            $height
        );
    }
}
