<?php

namespace ss\models\blocks\helpers\field\_base;

use ss\application\components\ValueGenerator;
use ss\application\components\Validator;
use ss\models\_abstract\AbstractModel;

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
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\' .
                        'field\\FieldGroupModel',
            ],
            'fieldTemplateId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\' .
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
