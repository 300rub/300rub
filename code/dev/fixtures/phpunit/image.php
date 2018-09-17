<?php

use ss\models\blocks\image\ImageModel;

return [
    1 => [
        'type'              => ImageModel::TYPE_SIMPLE,
        'autoCropType'      => ImageModel::AUTO_CROP_TYPE_NONE,
        'cropX'             => 0,
        'cropY'             => 0,
        'thumbAutoCropType' => ImageModel::AUTO_CROP_TYPE_NONE,
        'thumbCropX'        => 0,
        'thumbCropY'        => 0,
        'useAlbums'         => false,
    ],
    2 => [
        'type'              => ImageModel::TYPE_SLIDER,
        'autoCropType'      => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
        'cropX'             => 3,
        'cropY'             => 4,
        'thumbAutoCropType' => ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER,
        'thumbCropX'        => 1,
        'thumbCropY'        => 2,
        'useAlbums'         => true,
    ],
    3 => [
        'type'              => ImageModel::TYPE_ZOOM,
        'autoCropType'      => ImageModel::AUTO_CROP_TYPE_NONE,
        'cropX'             => 0,
        'cropY'             => 0,
        'thumbAutoCropType' => ImageModel::AUTO_CROP_TYPE_NONE,
        'thumbCropX'        => 0,
        'thumbCropY'        => 0,
        'useAlbums'         => true,
    ],
];
