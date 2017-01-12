<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;

/**
 * Model for working with table "texts"
 *
 * @package testS\models
 */
class TextModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_DIV = 0;
    const TYPE_H1 = 1;
    const TYPE_H2 = 2;
    const TYPE_H3 = 3;

    /**
     * List of tag type values
     *
     * @var array
     */
    public static $typeTagList = [
        self::TYPE_DIV => "div",
        self::TYPE_H1  => "h1",
        self::TYPE_H2  => "h2",
        self::TYPE_H3  => "h3",
    ];

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_DIV => Language::t("text", "typeDefault"),
            self::TYPE_H1  => Language::t("text", "typeH1"),
            self::TYPE_H2  => Language::t("text", "typeH2"),
            self::TYPE_H3  => Language::t("text", "typeH3"),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "texts";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designTextId"  => [
                self::FIELD_RELATION => ["DesignTextModel"]
            ],
            "designBlockId" => [
                self::FIELD_RELATION => ["DesignBlockModel"]
            ],
            "type"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [self::$typeTagList, self::TYPE_DIV]
                ],
            ],
            "hasEditor"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}