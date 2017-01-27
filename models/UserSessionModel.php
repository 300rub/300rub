<?php

namespace testS\models;

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
            "userId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "token"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 40,
                    Validator::TYPE_MIN_LENGTH => 40
                ],
            ],
            "isActive" => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "ip"       => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_IP
                ],
            ],
            "host"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "port"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "ua"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "date"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_DATETIME,
            ],
        ];
    }
}