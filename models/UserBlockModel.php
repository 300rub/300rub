<?php

namespace testS\models;

/**
 * Model for working with table "userBlocks"
 *
 * @package testS\models
 */
class UserBlockModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userBlocks";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"  => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "blockId" => [
                self::FIELD_RELATION_TO_PARENT => "BlockModel"
            ],
        ];
    }
}