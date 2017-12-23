<?php

namespace testS\models\blocks\helpers\field\_abstract;

use testS\application\components\ValueGenerator;
use testS\application\components\Validator;
use testS\models\_abstract\AbstractModel;

/**
 * Model for working with table "fieldInstances"
 */
abstract class AbstractFieldInstanceModel extends AbstractModel
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
                self::FIELD_RELATION_TO_PARENT => 'FieldGroupModel',
            ],
            'fieldTemplateId' => [
                self::FIELD_RELATION_TO_PARENT => 'FieldTemplateModel',
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
