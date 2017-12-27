<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "fieldGroups"
 */
abstract class AbstractFieldGroupModel extends AbstractModel
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
