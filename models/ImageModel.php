<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "images"
 *
 * @package testS\models
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
    public function getFieldsInfo()
    {
        return [
            "designBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "designImageSliderId" => [
                self::FIELD_RELATION => "DesignImageSliderModel"
            ],
            "designImageZoomId"   => [
                self::FIELD_RELATION => "DesignImageZoomModel"
            ],
            "designImageSimpleId" => [
                self::FIELD_RELATION => "DesignImageSimpleModel"
            ],
            "type"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList(), self::TYPE_ZOOM]
                ],
            ],
            "autoCropType"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getAutoCropTypeList(),
                        self::AUTO_CROP_TYPE_MIDDLE_CENTER
                    ]
                ],
            ],
            "cropWidth"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => ImageInstanceModel::MAX_SIZE
                ],
            ],
            "cropHeight"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => ImageInstanceModel::MAX_SIZE
                ],
            ],
            "cropX"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            "cropY"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            "thumbAutoCropType"   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getAutoCropTypeList(),
                        self::AUTO_CROP_TYPE_NONE
                    ]
                ],
            ],
            "thumbCropX"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            "thumbCropY"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            "useAlbums"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}