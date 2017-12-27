<?php

namespace testS\models\blocks\helpers\form\_base;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\blocks\helpers\form\_abstract\AbstractFormModel;

/**
 * Abstract model for working with table "formListValues"
 */
abstract class AbstractFormListValueModel extends AbstractFormModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'formListValues';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'formInstanceId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'form\\FormInstanceModel'
            ],
            'sort'           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
            'value'          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'isChecked'      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}
