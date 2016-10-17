<?php

namespace testS\models;

use testS\components\Language;

/**
 * Model for working with table "texts"
 *
 * @property int $type
 *
 * @method TextModel[] findAll
 * @method TextModel ordered
 * @method TextModel byId($id)
 * @method TextModel find
 * @method TextModel withAll
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
        self::TYPE_ADDRESS => "adress",
        self::TYPE_MARK    => "mark",
    ];

    /**
     * Gets model object
     *
     * @return TextModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
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
            "name"          => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => ["required", "max" => 255],
                self::FIELD_SET                 => ["clearStripTags"],
                self::FIELD_CHANGE_ON_DUPLICATE => "getCopyName",
            ],
            "language"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setLanguage"],
            ],
            "isEditor"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "type"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setType"],
            ],
            "text"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "designTextId"  => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignTextModel",
                    self::FIELD_RELATION_NAME  => "designTextModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designBlockId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ]
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
            self::TYPE_DIV     => Language::t("text", "typeDefault"),
            self::TYPE_H1      => Language::t("text", "typeH1"),
            self::TYPE_H2      => Language::t("text", "typeH2"),
            self::TYPE_H3      => Language::t("text", "typeH3"),
            self::TYPE_ADDRESS => Language::t("text", "typeAddress"),
            self::TYPE_MARK    => Language::t("text", "typeImportant"),
        ];
    }

    /**
     * Gets tag name
     *
     * @return string
     */
    public function getTag()
    {
        if (array_key_exists($this->type, self::$typeTagList)) {
            return self::$typeTagList[$this->type];
        }

        return self::$typeTagList[self::TYPE_DIV];
    }

    /**
     * Sets type
     *
     * @param int $value
     *
     * @return int
     */
    protected function setType($value)
    {
        if (!array_key_exists($value, self::$typeTagList)) {
            $value = self::TYPE_DIV;
        }

        return $value;
    }
}