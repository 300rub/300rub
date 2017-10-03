<?php

use testS\components\Operation;
use testS\models\BlockModel;

return [
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_ADD,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_DESIGN,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_CONTENT,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_UPDATE_SETTINGS,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_DELETE,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_TEXT,
        "operation" => Operation::TEXT_DUPLICATE,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPLOAD,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPLOAD,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPDATE,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_ADD,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPDATE_DESIGN,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPDATE_CONTENT,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_UPDATE_SETTINGS,
    ],
    [
        "userId"    => 3,
        "blockType" => BlockModel::TYPE_IMAGE,
        "operation" => Operation::IMAGE_DELETE,
    ],
];