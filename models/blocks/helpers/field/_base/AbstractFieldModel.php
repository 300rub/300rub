<?php

namespace testS\models\blocks\helpers\field\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "fields"
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
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'field\\DesignFieldModel'
            ],
        ];
    }
}
