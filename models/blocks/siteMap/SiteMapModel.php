<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "siteMaps"
 *
 * @package testS\models
 */
class SiteMapModel extends AbstractModel
{

    /**
     * Styles
     */
    const STYLE_COMMON = 0;
    const STYLE_ONE = 1;

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getStyleList()
    {
        return [
            self::STYLE_COMMON => "",
            self::STYLE_ONE    => "",
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "siteMaps";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "containerDesignBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "itemDesignBlockId"      => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "itemDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "style"                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getStyleList(),
                        self::STYLE_COMMON
                    ]
                ],
            ],
        ];
    }
}