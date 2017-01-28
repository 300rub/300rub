<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "catalogs"
 *
 * @package testS\models
 */
class CatalogModel extends AbstractModel
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
        return "catalogs";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "imageId"            => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "tabId"              => [
                self::FIELD_RELATION => "TabModel"
            ],
            "fieldId"            => [
                self::FIELD_RELATION => "FieldModel"
            ],
            "descriptionTextId"  => [
                self::FIELD_RELATION => "TextModel"
            ],
            "designCatalogId"    => [
                self::FIELD_RELATION => "DesignCatalogModel"
            ],
            "hasImages"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "useAutoload"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "pageNavigationSize" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "shortCardDateType"  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "fullCardDateType"   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            "hasRelations"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "relationsLabel"     => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "hasBin"             => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}