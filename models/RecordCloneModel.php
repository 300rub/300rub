<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "recordClones"
 *
 * @package testS\models
 */
class RecordCloneModel extends AbstractModel
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
        return "recordClones";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "recordId"            => [
                self::FIELD_RELATION => "RecordModel"
            ],
            "coverImagesId"       => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "descriptionTextId"   => [
                self::FIELD_RELATION => "TextModel"
            ],
            "designRecordCloneId" => [
                self::FIELD_RELATION => "DesignRecordCloneModel"
            ],
            "hasCover"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasCoverZoom"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "hasDescription"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "dateType"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "maxCount"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0
                ],
            ]
        ];
    }
}