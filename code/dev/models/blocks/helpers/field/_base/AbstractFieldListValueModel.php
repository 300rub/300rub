<?php

namespace ss\models\blocks\helpers\field\_base;


use ss\application\components\Validator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "fieldListValues"
 */
abstract class AbstractFieldListValueModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'fieldListValues';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'fieldTemplateId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\' .
                        'field\\FieldTemplateModel',
            ],
            'value'           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'sort'            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'isChecked'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}
