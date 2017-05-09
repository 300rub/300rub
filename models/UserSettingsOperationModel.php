<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Operation;
use testS\components\ValueGenerator;

/**
 * Model for working with table "userSettingsOperations"
 *
 * @package testS\models
 */
class UserSettingsOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSettingsOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"    => [
                self::FIELD_RELATION_TO_PARENT   => "UserModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "operation" => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [Operation::$settingsOperations]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId
     *
     * @return UserSettingsOperationModel
     */
    public function byUserId($userId)
    {
        $this->getDb()->addWhere(sprintf("%s.userId = :userId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("userId", $userId);

        return $this;
    }
}