<?php

namespace testS\models;

/**
 * Model for working with table "catalogInstances"
 *
 * @package testS\models
 */
class CatalogInstanceModel extends AbstractModel
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
        return "catalogInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "seoId"         => [
                self::FIELD_RELATION => "SeoModel"
            ],
            "tabGroupId"    => [
                self::FIELD_RELATION => "TabGroupModel"
            ],
            "imageGroupId"  => [
                self::FIELD_RELATION => "ImageGroupModel"
            ],
            "catalogMenuId" => [
                self::FIELD_RELATION_TO_PARENT => "CatalogMenuModel"
            ],
            "fieldGroupId"  => [
                self::FIELD_RELATION => "FieldGroupModel"
            ],
            "price"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_FLOAT
            ],
            "oldPrice"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_FLOAT
            ],
            "date"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_DATETIME
            ],
        ];
    }
}