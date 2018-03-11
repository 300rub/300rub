<?php

use ss\application\components\Language;

return [
    1 => [
        'seoModel'      => [
            'name' => 'Main page',
            'url'  => 'main'
        ],
        'language' => Language::LANGUAGE_EN_ID,
        'isMain'   => true,
    ],
    2 => [
        'seoModel'      => [
            'name' => 'Texts',
            'url'  => 'texts'
        ],
        'language' => Language::LANGUAGE_EN_ID,
        'isMain'   => false,
    ],
    3 => [
        'seoModel'      => [
            'name' => 'Images',
            'url'  => 'images'
        ],
        'language' => Language::LANGUAGE_EN_ID,
        'isMain'   => false,
    ],
];
