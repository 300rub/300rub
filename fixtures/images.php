<?php

use models\ImageModel;
use components\Language;
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
        "name"                 => "Zoom",
        "language"             => Language::LANGUAGE_EN_ID,
        "type"                 => ImageModel::TYPE_ZOOM,
        "use_crop"             => true,
        "auto_crop_type"       => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
        "crop_width"           => 640,
        "crop_height"          => 480,
        "thumb_auto_crop_type" => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
        "thumb_crop_x"         => 4,
        "thumb_crop_y"         => 3,
    ],
    3 => [
        "name"           => "Slider",
        "language"       => Language::LANGUAGE_EN_ID,
        "type"           => ImageModel::TYPE_SLIDER,
        "use_crop"       => true,
        "auto_crop_type" => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
        "crop_width"     => 980,
        "crop_height"    => 200,
    ],
    4 => [
        "name"                   => "Simple with albums",
        "language"               => Language::LANGUAGE_EN_ID,
        "designImageSimpleModel" => [
            "alignment" => DesignImageSimpleModel::ALIGNMENT_RIGHT
        ],
        "type"                   => ImageModel::TYPE_SIMPLE,
        "use_crop"               => true,
        "auto_crop_type"         => ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER,
        "crop_x"                 => 2,
        "crop_y"                 => 1,
        "use_albums"             => true,
    ],
    5 => [
        "name"                 => "Zoom with albums",
        "language"             => Language::LANGUAGE_EN_ID,
        "designImageZoomModel" => [
            "isScroll"             => true,
            "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_BOTTOM,
            "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_BOTTOM,
            "effect"                => DesignImageZoomModel::DEFAULT_EFFECT,
        ],
        "type"                 => ImageModel::TYPE_ZOOM,
        "use_crop"             => true,
        "auto_crop_type"       => ImageModel::AUTO_CROP_TYPE_TOP_LEFT,
        "crop_x"               => 1,
        "crop_y"               => 1,
        "thumb_crop_x"         => 1,
        "thumb_crop_y"         => 1,
        "use_albums"           => true,
    ],
    6 => [
        "name"                   => "Slider with albums",
        "language"               => Language::LANGUAGE_EN_ID,
        "designImageSliderModel" => [
            "effect"                => DesignImageSliderModel::DEFAULT_EFFECT,
            "is_auto_play"          => true,
            "play_speed"            => 5,
            "navigation_alignment"  => DesignImageSliderModel::DEFAULT_NAVIGATION_ALIGNMENT,
            "descriptionAlignment" => DesignImageSliderModel::DEFAULT_DESCRIPTION_ALIGNMENT,
        ],
        "type"                   => ImageModel::TYPE_SLIDER,
        "use_crop"               => true,
        "auto_crop_type"         => ImageModel::AUTO_CROP_TYPE_TOP_RIGHT,
        "crop_width"             => 980,
        "crop_height"            => 200,
        "use_albums"             => true,
    ],
];