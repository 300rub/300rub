<?php

namespace ss\models\blocks\helpers\form\_base;

use ss\application\App;
use ss\application\components\Validator;
use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "formInstances"
 */
abstract class AbstractFormInstanceModel extends AbstractModel
{

    /**
     * Validation types
     */
    const VALIDATION_TYPE_FREE_TEXT = 0;
    const VALIDATION_TYPE_NUMBER = 1;

    /**
     * Types
     */
    const TYPE_TEXT_FIELD = 0;
    const TYPE_DROP_DOWN = 1;

    /**
     * Gets a validation type list
     *
     * @return array
     */
    public static function getValidationTypeList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::VALIDATION_TYPE_FREE_TEXT
                => $language->getMessage('form', 'validationTypeFreeText'),
            self::VALIDATION_TYPE_NUMBER
                => ''
        ];
    }

    /**
     * Gets a type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::TYPE_TEXT_FIELD
                => $language->getMessage('form', 'typeTextField'),
            self::TYPE_DROP_DOWN
                => ''
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'formInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'formId'         => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\form\\FormModel'
            ],
            'sort'           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
            'label'          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'isRequired'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'validationType' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getValidationTypeList(),
                        self::VALIDATION_TYPE_FREE_TEXT
                    ]
                ]
            ],
            'type'           => [
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
