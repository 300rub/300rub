<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "imageInstances"
 *
 * @package testS\models
 */
class ImageInstanceModel extends AbstractModel
{

    /**
     * Min size in px
     */
    const MIN_SIZE = 32;

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
            ],
            "fileName"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "isCover"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "sort"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "alt"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
            "width"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => self::MIN_SIZE,
                    ValueGenerator::TYPE_MAX => self::MAX_SIZE
                ],
            ],
            "height"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => self::MIN_SIZE,
                    ValueGenerator::TYPE_MAX => self::MAX_SIZE
                ],
            ],
            "x1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0,
                    ValueGenerator::TYPE_MAX => ["{width}", self::MIN_SIZE, "-"]
                ],
            ],
            "y1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0,
                    ValueGenerator::TYPE_MAX => ["{height}", self::MIN_SIZE, "-"]
                ],
            ],
            "x2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => ["{x1}", self::MIN_SIZE, "+"],
                    ValueGenerator::TYPE_MAX => "{width}"
                ],
            ],
            "y2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => ["{y1}", self::MIN_SIZE, "+"],
                    ValueGenerator::TYPE_MAX => "{height}"
                ]
            ],
            "thumbX1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0,
                    ValueGenerator::TYPE_MAX => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbY1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0,
                    ValueGenerator::TYPE_MAX => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbX2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => ["{thumbX1}", self::MIN_SIZE, "+"],
                    ValueGenerator::TYPE_MAX => self::MAX_THUMB_SIZE
                ]
            ],
            "thumbY2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => ["{thumbY1}", self::MIN_SIZE, "+"],
                    ValueGenerator::TYPE_MAX => self::MAX_THUMB_SIZE
                ]
            ],
        ];
    }
}