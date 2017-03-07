<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "blocks"
 *
 * @package testS\models
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
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT  => "TextModel",
        self::TYPE_IMAGE => "ImageModel"
    ];

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
            "name"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_NAME
                ],
            ],
            "language"    => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [Language::$aliasList, Language::getActiveId()]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "contentType" => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "contentId"   => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE          => ["setContentIdBeforeSave"],
                self::FIELD_BEFORE_DUPLICATE     => ["setContentIdBeforeDuplicate"],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }

    /**
     * Sets and checks content ID
     *
     * @param int $value
     *
     * @throws ModelException
     *
     * @return int
     */
    protected function setContentIdBeforeSave($value)
    {
        $value = (int) $value;

        if ($value === 0) {
            throw new ModelException("Unable to save BlockModel because contentId is null");
        }

        $this->getModelByTypeAndId($this->get("contentType"), $value);

        return $value;
    }

    /**
     * Sets contentId before duplicate
     *
     * @param int $value
     *
     * @return int
     *
     * @throws ModelException
     */
    protected function setContentIdBeforeDuplicate($value)
    {
        return $this
            ->getModelByTypeAndId($this->get("contentType"), $value)
            ->duplicate()
            ->getId();
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param int $type
     * @param int $id
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    public function getModelByTypeAndId($type, $id)
    {
        $className = "\\testS\\models\\" . self::$typeList[$type];
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($id)->find() instanceof AbstractModel
        ) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => $className,
                    "id"        => $id
                ]
            );
        }

        return $model;
    }
}