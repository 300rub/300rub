<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "records"
 *
 * @package testS\models
 */
class RecordModel extends AbstractModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "records";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "coverImagesId"       => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "imagesImagesId" => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "descriptionTextId"   => [
                self::FIELD_RELATION => "TextModel"
            ],
            "textTextId" => [
                self::FIELD_RELATION => "TextModel"
            ],
            "designRecordsId" => [
                self::FIELD_RELATION => "DesignRecordModel"
            ],
            "hasCover"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasImages"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasCoverZoom"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasDescription"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasAutoload"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "shortCardDateType"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "fullCardDateType"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
        ];
    }
}