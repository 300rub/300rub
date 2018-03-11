<?php

use ss\models\blocks\block\BlockModel;
use ss\application\components\Language;

return [
    1 => [
        'name'        => 'Main page menu',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_MENU,
        'contentId'   => 1,
    ],
    2 => [
        'name'        => 'Text menu',
        'language'    => Language::LANGUAGE_EN_ID,
        'contentType' => BlockModel::TYPE_MENU,
        'contentId'   => 2,
    ],
];
