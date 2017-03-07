<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "textInstances"
 *
 * @package testS\models
 */
class TextInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "textInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "textId"  => [
                self::FIELD_RELATION_TO_PARENT   => "TextModel",
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            "text"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ]
        ];
    }
}