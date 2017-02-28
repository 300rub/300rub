<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Validator;
use DateTime;

/**
 * Model for working with table "userSessions"
 *
 * @package testS\models
 *
 * @method UserSessionModel   find()
 * @method UserSessionModel[] findAll()
 */
class UserSessionModel extends AbstractModel
{

    /**
     * Online value in seconds (10 min)
     */
    const ONLINE_VALUE = 600;

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

    /**
     * Finds by user ID
     *
     * @param int $userId
     *
     * @return UserSessionModel
     */
    public function byUserId($userId)
    {
        $this->getDb()->addWhere(sprintf("%s.userId = :userId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("userId", $userId);

        return $this;
    }

    /**
     * Adds ORDER BY to SQL request
     *
     * @return UserSessionModel
     */
    public function ordered()
    {
        $this->getDb()->setOrder(sprintf("%s.lastActivity DESC", Db::DEFAULT_ALIAS));
        return $this;
    }

    /**
     * Gets formatted last Activity
     *
     * @return string
     */
    public function getFormattedLastActivity()
    {
        /**
         * @var DateTime $lastActivity
         */
        $lastActivity = $this->get("lastActivity");
        if (!$lastActivity instanceof DateTime) {
            return "";
        }

        return $lastActivity->format("d/m/Y H:i");
    }

    /**
     * Flag is online
     *
     * @return bool
     */
    public function isOnline()
    {
        /**
         * @var DateTime $lastActivity
         */
        $lastActivity = $this->get("lastActivity");
        if (!$lastActivity instanceof DateTime) {
            return false;
        }

        return time() - $lastActivity->getTimestamp() < self::ONLINE_VALUE;
    }
}