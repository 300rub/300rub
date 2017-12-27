<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Model for working with table "fields"
 */
abstract class AbstractFieldModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'fields';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designFieldId'       => [
                self::FIELD_RELATION => 'DesignFieldModel'
            ],
        ];
    }
}
