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
    4 => [
        'name'        => 'Image Simple',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_IMAGE,
        'contentId'   => 3,
    ],
    5 => [
        'name'        => 'Albums zoom',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_IMAGE,
        'contentId'   => 4,
    ],
    6 => [
        'name'        => 'Record autoload',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_RECORD,
        'contentId'   => 1,
    ],
    7 => [
        'name'        => 'Simple text',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_TEXT,
        'contentId'   => 1,
    ],
    8 => [
        'name'        => 'Stylised text',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_TEXT,
        'contentId'   => 2,
    ],
    9 => [
        'name'        => 'Record pagination',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_RECORD,
        'contentId'   => 2,
    ],
    10 => [
        'name'        => 'Record clone',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_RECORD_CLONE,
        'contentId'   => 1,
    ],
];
