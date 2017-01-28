<?php

namespace testS\models;

use testS\components\ValueGenerator;
use testS\components\Validator;

/**
 * Model for working with table "fieldTemplates"
 *
 * @package testS\models
 */
class FieldTemplateModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_TEXT_FIELD = 0;

    /**
     * Validation types
     */
    const VALIDATION_FREE_TEXT = 0;

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_TEXT_FIELD => ""
        ];
    }

    /**
     * Gets a list of validation types
     *
     * @return array
     */
    public static function getValidationTypeList()
    {
        return [
            self::VALIDATION_FREE_TEXT => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "fieldTemplates";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "fieldId"            => [
                self::FIELD_RELATION_TO_PARENT => "FieldModel",
            ],
            "sort"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "label"              => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "type"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList(), self::TYPE_TEXT_FIELD],
                ],
            ],
            "validationType"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getValidationTypeList(), self::VALIDATION_FREE_TEXT],
                ],
            ],
            "isHideForShortCard" => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "isShowEmpty"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}