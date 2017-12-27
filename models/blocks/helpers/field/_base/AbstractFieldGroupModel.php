<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\models\blocks\helpers\field\_abstract\AbstractFieldModel;

/**
 * Abstract model for working with table "fieldGroups"
 */
abstract class AbstractFieldGroupModel extends AbstractFieldModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'fieldGroups';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'fieldId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\field\\FieldModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }
}
