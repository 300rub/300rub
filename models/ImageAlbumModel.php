<?php

namespace testS\models;

/**
 * Model for working with table "imageAlbums"
 *
 * @package testS\models
 */
class ImageAlbumModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "imageAlbums";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "imageId" => [
                self::FIELD_RELATION_TO_PARENT => "ImageModel",
            ],
            "name"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    "required",
                    "max" => 255
                ],
                self::FIELD_VALUE      => [
                    "clearStripTags"
                ],
            ],
            "sort"    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}