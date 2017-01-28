<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "formInstances"
 *
 * @package testS\models
 */
class FormInstanceModel extends AbstractModel
{

    /**
     * Validation types
     */
    const VALIDATION_TYPE_FREE_TEXT = 0;

    /**
     * Types
     */
    const TYPE_TEXT_FIELD = 0;

    /**
     * Gets a validation type list
     *
     * @return array
     */
    public static function getValidationTypeList()
    {
        return [
            self::VALIDATION_TYPE_FREE_TEXT => Language::t("form", "validationTypeFreeText")
        ];
    }

    /**
     * Gets a type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_TEXT_FIELD => Language::t("form", "typeTextField")
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "formInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "formId"         => [
                self::FIELD_RELATION_TO_PARENT => "FormModel"
            ],
            "sort"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
            "label"          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "isRequired"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "validationType" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getValidationTypeList(),
                        self::VALIDATION_TYPE_FREE_TEXT
                    ]
                ]
            ],
            "type"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getTypeList(),
                        self::TYPE_TEXT_FIELD
                    ]
                ]
            ],
        ];
    }
}