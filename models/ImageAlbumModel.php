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
    protected function getFieldsInfo()
    {
        return [
            "name"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => ["required", "max" => 255],
                self::FIELD_SET        => ["clearStripTags"],
            ],
            "sort"    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "imageId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "ImageModel",
                    self::FIELD_RELATION_NAME  => "imageModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_HAS_ONE
                ]
            ],
        ];
    }

    /**
     * Add condition for select by image ID
     *
     * @param integer $imageId Image ID
     *
     * @return ImageAlbumModel
     */
    public function byImageId($imageId)
    {
        $this->getDb()
            ->addWhere("imageId = :imageId")
            ->addParameter("imageId", $imageId);

        return $this;
    }
}