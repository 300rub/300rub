<?php

use testS\components\Operation;
use testS\models\BlockModel;

return [
    1 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_ADD,
    ],
    2 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_DESIGN,
    ],
    3 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_CONTENT,
    ],
    4 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_SETTINGS,
    ],
    5 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_DELETE,
    ],
    6 => [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPLOAD,
    ],
];