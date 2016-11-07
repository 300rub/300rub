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
 * @method GridModel[] findAll()
 * @method GridModel   in($field, $values)
 * @method GridModel   with($array)
 * @method GridModel   ordered($value)
 */
class GridModel extends AbstractModel
{

    /**
     * Grid size
     */
    const GRID_SIZE = 12;

    /**
     * Default width
     */
    const DEFAULT_WIDTH = 3;

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
        return "grids";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "x"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "max" => self::GRID_SIZE - 1,
                    "min" => 0
                ]
            ],
            "y"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0
                ]
            ],
            "width"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "minThen" => [0, self::DEFAULT_WIDTH],
                    "max"     => [self::GRID_SIZE, "{x}", "-"]
                ],
            ],
            "contentType" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "contentId"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "gridLineId"  => [
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
        if ($this->contentType === 0 || $this->contentId === 0) {
            throw new ModelException("Unable to save GridModel because contentType or contentId is null");
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
            || !$model->byId($this->contentId)->find()
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