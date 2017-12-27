<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\application\components\ValueGenerator;
use testS\application\components\Validator;
use testS\models\blocks\helpers\field\_abstract\AbstractFieldModel;

/**
 * Model for working with table "fieldInstances"
 */
abstract class AbstractFieldInstanceModel extends AbstractFieldModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'fieldInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'fieldGroupId'    => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'field\\FieldGroupModel',
            ],
            'fieldTemplateId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'field\\FieldTemplateModel',
            ],
            'value'           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}
