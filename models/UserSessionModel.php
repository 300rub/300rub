<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Validator;

/**
 * Model for working with table "userSessions"
 *
 * @package testS\models
 */
class UserSessionModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSessions";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"       => [
                self::FIELD_RELATION_TO_PARENT   => "UserModel",
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            "token"        => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION           => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 32,
                    Validator::TYPE_MIN_LENGTH => 32
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            "ip"           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_IP
                ],
            ],
            "ua"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "lastActivity" => [
                self::FIELD_TYPE              => self::FIELD_TYPE_DATETIME,
                self::FIELD_CURRENT_DATE_TIME => true
            ],
        ];
    }

    /**
     * Finds by token
     *
     * @param string $token
     *
     * @return UserSessionModel
     */
    public function byToken($token)
    {
        $this->getDb()->addWhere(sprintf("%s.token = :token", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("token", $token);

        return $this;
    }
}