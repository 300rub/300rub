<?php

namespace ss\models\blocks\helpers\field\_base;


use ss\application\components\common\Validator;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "fieldTemplates"
 */
abstract class AbstractFieldTemplateModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_TEXT_FIELD = 0;
    const TYPE_DROP_DOWN = 1;

    /**
     * Validation types
     */
    const VALIDATION_FREE_TEXT = 0;
    const VALIDATION_NUMBER = 1;

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_TEXT_FIELD => '',
            self::TYPE_DROP_DOWN  => '',
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
            self::VALIDATION_FREE_TEXT => '',
            self::VALIDATION_NUMBER    => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'fieldTemplates';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'fieldId'            => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\field\\FieldModel',
            ],
            'sort'               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'label'              => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'type'               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getTypeList(),
                        self::TYPE_TEXT_FIELD
                    ],
                ],
            ],
            'validationType'     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getValidationTypeList(),
                        self::VALIDATION_FREE_TEXT
                    ],
                ],
            ],
            'isHideForShortCard' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'isShowEmpty'        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}
