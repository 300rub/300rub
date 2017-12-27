<?php

namespace testS\models\system\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "help"
 */
abstract class AbstractHelpModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'help';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'language' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'category' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'name'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'content'  => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
        ];
    }
}
