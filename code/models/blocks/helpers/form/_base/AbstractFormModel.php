<?php

namespace ss\models\blocks\helpers\form\_base;

use ss\application\components\common\Validator;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Model for working with table "forms"
 */
abstract class AbstractFormModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'forms';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designFormId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\form\\DesignFormModel'
            ],
            'hasLabel'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'successText'  => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}
