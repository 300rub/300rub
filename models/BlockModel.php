<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "grids"
 *
 * @package testS\models
 *
 * @property int           $contentType
 * @property int           $contentId
 *
 * @method BlockModel[] findAll()
 * @method BlockModel   ordered($value)
 */
class BlockModel extends AbstractModel
{

    /**
     * Content types. Text
     */
    const TYPE_TEXT = 1;

    /**
     * Content types. Image
     */
    const TYPE_IMAGE = 2;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "blocks";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "name"          => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    "required",
                    "max" => 255
                ],
                self::FIELD_VALUE               => [
                    "clearStripTags"
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    "copyName"
                ],
            ],
            "language"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [Language::$aliasList, Language::$activeId]
                ],
            ],
            "contentType" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "contentId"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }

    /**
     * Gets content types list
     *
     * @return array
     */
    public static function getTypesList()
    {
        return [
            self::TYPE_TEXT => [
                "name"     => Language::t("text", "text"),
                "model"    => "TextModel",
                "view"     => "text",
                "selector" => "j-text-",
                "with"     => ["designTextModel"]
            ]
        ];
    }

    /**
     * Runs before save
     *
     * @throws ModelException
     */
    protected function beforeSave()
    {
        if ($this->contentType === 0) {
            throw new ModelException("Unable to save BlockModel because contentType is null");
        }

        if ($this->contentId === 0) {
            throw new ModelException("Unable to save BlockModel because contentId is null");
        }

        $typeList = self::getTypesList();
        if (!array_key_exists($this->contentType, $typeList)) {
            throw new ModelException(
                "Unable to find content model. Type is undefined: {type}",
                [
                    "type" => $this->contentType
                ]
            );
        }

        $className = "\\testS\\models\\" . $typeList[$this->contentType]["model"];
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($this->contentId)->find() instanceof AbstractModel
        ) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => $className,
                    "id"        => $this->contentId
                ]
            );
        }

        parent::beforeSave();
    }
}