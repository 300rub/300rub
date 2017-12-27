<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\models\blocks\helpers\field\_abstract\AbstractFieldModel as Model;

/**
 * Abstract model for working with table "fields"
 */
abstract class AbstractFieldModel extends Model
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
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\helpers\\field\\DesignFieldModel'
            ],
        ];
    }
}
