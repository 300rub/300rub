<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "imageInstances"
 *
 * @package testS\models
 */
class ImageInstanceModel extends AbstractModel
{

    /**
     * Max size in px
     */
    const MAX_SIZE = 2000;

    /**
     * Max thumb size in px
     */
    const MAX_THUMB_SIZE = 300;

    /**
     * View prefix
     */
    const VIEW_PREFIX = "view_";

    /**
     * Thumb prefix
     */
    const THUMB_PREFIX = "thumb_";

    /**
     * File name length
     */
    const FILE_NAME_LENGTH = 16;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "imageInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "imageAlbumId" => [
                self::FIELD_RELATION_TO_PARENT => "ImageGroupModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "fileName"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 25,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "isCover"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "sort"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "alt"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "width"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "height"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_THUMB_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_THUMB_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_THUMB_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::MAX_THUMB_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}