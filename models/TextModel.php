<?php

namespace testS\models;

use testS\components\Language;

/**
 * Model for working with table "texts"
 *
 * @property string $name
 *
 * @method TextModel[] findAll
 * @method TextModel   ordered
 * @method TextModel   byId($id)
 * @method TextModel   find
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
    const TYPE_ADDRESS = 4;
    const TYPE_MARK = 5;

    /**
     * List of tag type values
     *
     * @var array
     */
    public static $typeTagList = [
        self::TYPE_DIV     => "div",
        self::TYPE_H1      => "h1",
        self::TYPE_H2      => "h2",
        self::TYPE_H3      => "h3",
        self::TYPE_ADDRESS => "address",
        self::TYPE_MARK    => "mark",
    ];

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_DIV     => Language::t("text", "typeDefault"),
            self::TYPE_H1      => Language::t("text", "typeH1"),
            self::TYPE_H2      => Language::t("text", "typeH2"),
            self::TYPE_H3      => Language::t("text", "typeH3"),
            self::TYPE_ADDRESS => Language::t("text", "typeAddress"),
            self::TYPE_MARK    => Language::t("text", "typeImportant"),
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
    protected function getFieldsInfo()
    {
        return [
            "designTextId"  => [
                self::FIELD_RELATION => ["DesignTextModel", "designTextModel"]
            ],
            "designBlockId" => [
                self::FIELD_RELATION => ["DesignBlockModel", "designBlockModel"]
            ],
            "name"          => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => ["required", "max" => 255],
                self::FIELD_VALUE               => ["clearStripTags"],
                self::FIELD_CHANGE_ON_DUPLICATE => "getCopyName",
            ],
            "language"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [Language::$aliasList, Language::$activeId]
                ],
            ],
            "isEditor"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "type"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => ["arrayKey" => [self::$typeTagList, self::TYPE_DIV]],
            ],
            "text"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ]
        ];
    }
}