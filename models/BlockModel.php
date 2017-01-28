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
 *
 * @property int $contentType
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
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [Language::$aliasList, Language::getActiveId()]
                ],
            ],
            "contentType" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
            ],
            "contentId"   => [
                self::FIELD_TYPE        => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE => "checkContentId"
            ],
        ];
    }

    /**
     * Checks content ID
     *
     * @param int $value
     *
     * @throws ModelException
     */
    protected function checkContentId($value)
    {
        if ($value === 0) {
            throw new ModelException("Unable to save BlockModel because contentId is null");
        }

        $className = "\\testS\\models\\" . self::$typeList[$this->contentType];
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($value)->find() instanceof AbstractModel
        ) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => $className,
                    "id"        => $value
                ]
            );
        }
    }
}