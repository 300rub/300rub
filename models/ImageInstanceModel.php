<?php

namespace testS\models;

/**
 * Model for working with table "imageInstances"
 *
 * @method ImageInstanceModel[] findAll
 * @method ImageInstanceModel   byId($id)
 * @method ImageInstanceModel   find
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
     * Format of file
     *
     * @var string
     */
    private $_format = "jpg";

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
                self::FIELD_RELATION_TO_PARENT => "ImageAlbumModel",
            ],
            "fileName"     => [
                self::FIELD_TYPE        => self::FIELD_TYPE_STRING,
                self::FIELD_BEFORE_SAVE => [
                    "setFileName"
                ],
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
                    "clearStripTags"
                ],
            ],
            "width"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => self::MIN_SIZE,
                    "max" => self::MAX_SIZE
                ],
            ],
            "height"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => self::MIN_SIZE,
                    "max" => self::MAX_SIZE
                ],
            ],
            "x1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0,
                    "max" => ["{width}", self::MIN_SIZE, "-"]
                ],
            ],
            "y1"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0,
                    "max" => ["{height}", self::MIN_SIZE, "-"]
                ],
            ],
            "x2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => ["{x1}", self::MIN_SIZE, "+"],
                    "max" => "{width}"
                ],
            ],
            "y2"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => ["{y1}", self::MIN_SIZE, "+"],
                    "max" => "{height}"
                ]
            ],
            "thumbX1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0,
                    "max" => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbY1"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0,
                    "max" => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbX2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => ["{thumbX1}", self::MIN_SIZE, "+"],
                    "max" => self::MAX_THUMB_SIZE
                ]
            ],
            "thumbY2"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => ["{thumbY1}", self::MIN_SIZE, "+"],
                    "max" => self::MAX_THUMB_SIZE
                ]
            ],
        ];
    }

    /**
     * Sets file name
     *
     * @param string $value
     *
     * @return string
     */
    protected function setFileName($value)
    {
        if (!$this->id && $this->_format) {
            return substr(md5(time()), 0, self::FILE_NAME_LENGTH) . "." . $this->_format;
        }

        return $value;
    }
}