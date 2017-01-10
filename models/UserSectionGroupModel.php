<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "userSectionGroups"
 *
 * @package testS\models
 */
class UserSectionGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSectionGroups";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
        ];
    }
}