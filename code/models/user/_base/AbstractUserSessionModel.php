<?php

namespace ss\models\user\_base;

use ss\application\components\common\Validator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "userSessions"
 */
abstract class AbstractUserSessionModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'userSessions';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'userId'       => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\user\\UserModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'token'        => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION           => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 32,
                    Validator::TYPE_MIN_LENGTH => 32
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'ip'           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_IP
                ],
            ],
            'ua'           => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'lastActivity' => [
                self::FIELD_TYPE              => self::FIELD_TYPE_DATETIME,
                self::FIELD_CURRENT_DATE_TIME => true
            ],
        ];
    }
}
