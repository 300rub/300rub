<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "menu"
 *
 * @package testS\models
 */
class MenuModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_VERTICAL = 0;
    const TYPE_HORIZONTAL = 1;

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_VERTICAL   => "",
            self::TYPE_HORIZONTAL => "",
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "menu";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designMenuId"       => [
                self::FIELD_RELATION => "DesignMenuModel"
            ],
            "type"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getTypeList(),
                        self::TYPE_VERTICAL
                    ]
                ],
            ],
        ];
    }
}