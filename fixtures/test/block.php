<?php

use testS\models\blocks\block\BlockModel;

return [
    1 => [
        "name"        => "Simple text",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_TEXT,
        "contentId"   => 1,
    ],
    2 => [
        "name"        => "Text with editor",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_TEXT,
        "contentId"   => 2,
    ],
    3 => [
        "name"        => "Zoom image",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_IMAGE,
        "contentId"   => 1,
    ],
    4 => [
        "name"        => "Slider image",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_IMAGE,
        "contentId"   => 2,
    ],
    5 => [
        "name"        => "Zoom image with albums",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_IMAGE,
        "contentId"   => 3,
    ],
    6 => [
        "name"        => "Records 1",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_RECORD,
        "contentId"   => 1,
    ],
    7 => [
        "name"        => "Records 1 clone 1",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_RECORD_CLONE,
        "contentId"   => 1,
    ],
    8 => [
        "name"        => "Records 2",
        "language"    => 1,
        "contentType" => BlockModel::TYPE_RECORD,
        "contentId"   => 2,
    ],
];