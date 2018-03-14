<?php

use ss\models\blocks\block\BlockModel;
use ss\application\components\Language;

return [
    1 => [
        'name'        => 'Main menu',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_MENU,
        'contentId'   => 1,
    ],
    2 => [
        'name'        => 'Image Zoom',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_IMAGE,
        'contentId'   => 1,
    ],
    3 => [
        'name'        => 'Image Slider',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_IMAGE,
        'contentId'   => 2,
    ],
];
