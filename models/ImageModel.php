<?php

namespace testS\models;

use testS\components\exceptions\ModelException;

/**
 * Model for working with table "images"
 *
 * @package testS\models
 *
 * @method ImageModel[] findAll
 * @method ImageModel   byId($id)
 * @method ImageModel   find
 */
class ImageModel extends AbstractModel
{

    /**
     * Crop types
     */
    const AUTO_CROP_TYPE_NONE = 0;
    const AUTO_CROP_TYPE_TOP_LEFT = 1;
    const AUTO_CROP_TYPE_TOP_CENTER = 2;
    const AUTO_CROP_TYPE_TOP_RIGHT = 3;
    const AUTO_CROP_TYPE_MIDDLE_LEFT = 4;
    const AUTO_CROP_TYPE_MIDDLE_CENTER = 5;
    const AUTO_CROP_TYPE_MIDDLE_RIGHT = 6;
    const AUTO_CROP_TYPE_BOTTOM_LEFT = 7;
    const AUTO_CROP_TYPE_BOTTOM_CENTER = 8;
    const AUTO_CROP_TYPE_BOTTOM_RIGHT = 9;

    /**
     * Types
     */
    const TYPE_ZOOM = 0;
    const TYPE_SLIDER = 1;
    const TYPE_SIMPLE = 2;

    /**
     * Gets crop type list
     *
     * @return array
     */
    public static function getAutoCropTypeList()
    {
        return [
            self::AUTO_CROP_TYPE_NONE          => "",
            self::AUTO_CROP_TYPE_TOP_LEFT      => "",
            self::AUTO_CROP_TYPE_TOP_CENTER    => "",
            self::AUTO_CROP_TYPE_TOP_RIGHT     => "",
            self::AUTO_CROP_TYPE_MIDDLE_LEFT   => "",
            self::AUTO_CROP_TYPE_MIDDLE_CENTER => "",
            self::AUTO_CROP_TYPE_MIDDLE_RIGHT  => "",
            self::AUTO_CROP_TYPE_BOTTOM_LEFT   => "",
            self::AUTO_CROP_TYPE_BOTTOM_CENTER => "",
            self::AUTO_CROP_TYPE_BOTTOM_RIGHT  => ""
        ];
    }

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_ZOOM   => "",
            self::TYPE_SLIDER => "",
            self::TYPE_SIMPLE => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "images";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "name"                => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => ["required", "max" => 255],
                self::FIELD_SET        => ["clearStripTags"],
            ],
            "language"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setLanguage"],
            ],
            "type"                => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [self::getTypeList(), self::TYPE_ZOOM]
                ],
            ],
            "autoCropType"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [self::getAutoCropTypeList(), self::AUTO_CROP_TYPE_MIDDLE_CENTER]
                ],
            ],
            "cropWidth"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMax" => ImageInstanceModel::MAX_SIZE],
            ],
            "cropHeight"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMax" => ImageInstanceModel::MAX_SIZE],
            ],
            "cropX"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "cropY"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbAutoCropType"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setAutoCropType"],
            ],
            "thumbCropX"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbCropY"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "useAlbums"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "designBlockId"       => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageSliderId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageSliderModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageZoomId"   => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageZoomModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageSimpleId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageSimpleModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
        ];
    }

    /**
     * Runs before delete
     *
     * @throws ModelException
     */
    protected function beforeDelete()
    {
        // delete images ()

        parent::beforeDelete();
    }
}