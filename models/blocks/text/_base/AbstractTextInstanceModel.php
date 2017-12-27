<?php

namespace testS\models\blocks\text\_base;

use testS\models\blocks\text\_abstract\AbstractTextModel;

/**
 * Abstract model for working with table "textInstances"
 */
abstract class AbstractTextInstanceModel extends AbstractTextModel
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
                    => '\\testS\\models\\blocks\\text\\TextModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'text'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ]
        ];
    }
}
