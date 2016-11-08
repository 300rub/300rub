<?php

namespace testS\models;

/**
 * Model for working with table "imageAlbums"
 *
 * @package testS\models
 *
 * @method ImageAlbumModel[] findAll
 * @method ImageAlbumModel   byId($id)
 * @method ImageAlbumModel   find
 * @method ImageAlbumModel   withAll
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
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0
                ],
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