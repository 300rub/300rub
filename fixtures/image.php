<?php

use models\ImageModel;
use testS\components\Language;
use models\DesignImageSimpleModel;
use models\DesignImageZoomModel;
use models\DesignImageSliderModel;

return [
    1 => [
        "name"     => "Simple",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => ImageModel::TYPE_SIMPLE,
    ],
    2 => [
        "name"              => "Zoom",
        "language"          => Language::LANGUAGE_EN_ID,
        "type"              => ImageModel::TYPE_ZOOM,
        "autoCropType"      => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
        "cropWidth"         => 640,
        "cropHeight"        => 480,
        "thumbAutoCropType" => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
        "thumbCropX"       => 4,
        "thumbCropY"       => 3,
    ],
    3 => [
        "name"         => "Slider",
        "language"     => Language::LANGUAGE_EN_ID,
        "type"         => ImageModel::TYPE_SLIDER,
        "autoCropType" => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
        "cropWidth"    => 980,
        "cropHeight"   => 200,
    ],
    4 => [
        "name"                   => "Simple with albums",
        "language"               => Language::LANGUAGE_EN_ID,
        "designImageSimpleModel" => [
            "alignment" => DesignImageSimpleModel::ALIGNMENT_RIGHT
        ],
        "type"                   => ImageModel::TYPE_SIMPLE,
        "autoCropType"           => ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER,
        "cropX"                  => 2,
        "cropY"                  => 1,
        "useAlbums"              => true,
    ],
    5 => [
        "name"                 => "Zoom with albums",
        "language"             => Language::LANGUAGE_EN_ID,
        "designImageZoomModel" => [
            "isScroll"             => true,
            "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_BOTTOM,
            "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_BOTTOM,
            "effect"               => DesignImageZoomModel::DEFAULT_EFFECT,
        ],
        "type"                 => ImageModel::TYPE_ZOOM,
        "autoCropType"         => ImageModel::AUTO_CROP_TYPE_TOP_LEFT,
        "cropX"                => 1,
        "cropY"                => 1,
        "thumbCropX"          => 1,
        "thumbCropY"          => 1,
        "useAlbums"            => true,
    ],
    6 => [
        "name"                   => "Slider with albums",
        "language"               => Language::LANGUAGE_EN_ID,
        "designImageSliderModel" => [
            "effect"               => DesignImageSliderModel::DEFAULT_EFFECT,
            "isAutoPlay"           => true,
            "playSpeed"            => 5,
            "navigationAlignment"  => DesignImageSliderModel::DEFAULT_NAVIGATION_ALIGNMENT,
            "descriptionAlignment" => DesignImageSliderModel::DEFAULT_DESCRIPTION_ALIGNMENT,
        ],
        "type"                   => ImageModel::TYPE_SLIDER,
        "autoCropType"           => ImageModel::AUTO_CROP_TYPE_TOP_RIGHT,
        "cropWidth"              => 980,
        "cropHeight"             => 200,
        "useAlbums"              => true,
    ],
];