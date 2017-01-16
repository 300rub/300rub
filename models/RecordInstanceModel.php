<?php

namespace testS\models;

/**
 * Model for working with table "recordInstances"
 *
 * @package testS\models
 */
class RecordInstanceModel extends AbstractModel
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
        return "recordInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "recordId"                  => [
                self::FIELD_RELATION_TO_PARENT => "RecordModel"
            ],
            "seoId"                     => [
                self::FIELD_RELATION => "SeoModel"
            ],
            "textTextInstanceId"        => [
                self::FIELD_RELATION => "TextInstanceModel"
            ],
            "descriptionTextInstanceId" => [
                self::FIELD_RELATION => "TextInstanceModel"
            ],
            "imageGroupId"              => [
                self::FIELD_RELATION => "ImageGroupModel"
            ],
            "coverImageInstanceId"      => [
                self::FIELD_RELATION => "ImageInstanceModel"
            ],
            "date"                      => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ],
            "sort"                      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
        ];
    }
}