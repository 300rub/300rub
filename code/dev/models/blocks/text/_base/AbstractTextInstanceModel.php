<?php

namespace ss\models\blocks\text\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "textInstances"
 */
abstract class AbstractTextInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'textInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'textId'  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\text\\TextModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'text'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ]
        ];
    }
}
