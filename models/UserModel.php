<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Validator;

/**
 * Model for working with table "users"
 *
 * @package testS\models
 */
class UserModel extends AbstractModel
{

    /**
     * Password salt
     */
    const PASSWORD_SALT = "(^_^)";

    /**
     * Length of password
     */
    const PASSWORD_HASH_LENGTH = 40;

    /**
     * Remember or not
     *
     * @var bool
     */
    public $isRemember = false;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "users";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "login"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 3,
                    Validator::TYPE_MAX_LENGTH => 50,
                    Validator::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN
                ],
                self::FIELD_BEFORE_SAVE => ["setLogin"],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "password" => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 40,
                    Validator::TYPE_MAX_LENGTH => 40,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "isOwner" => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_BEFORE_SAVE => ["setIsOwner"],
            ],
            "name"     => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 100,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "email"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_EMAIL,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Sets is owner
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function setIsOwner($value)
    {
        if ($value === true) {
            return $this->owner()->find() === null;
        }

        return false;
    }

    /**
     * Sets login
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function setLogin($value)
    {
        if (!$this->isNew()) {
            return $value;
        }

        $model = $this->byLogin($value)->find();
        if ($model !== null) {
            $this->addErrors("login", [Validator::TYPE_UNIQUE]);
        }

        return $value;
    }

    /**
     * Adds login condition to SQL request
     *
     * @param string $login
     *
     * @return UserModel
     */
    public function byLogin($login)
    {
        $this->getDb()->addWhere(sprintf("%s.login = :login", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("login", $login);

        return $this;
    }

    /**
     * Adds owner condition to SQL request
     *
     * @return UserModel
     */
    public function owner()
    {
        $this->getDb()->addWhere(sprintf("%s.isOwner = :isOwner", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("isOwner", 1);

        return $this;
    }

    /**
     * Gets operations by user ID
     *
     * @return array
     */
    public function getOperations()
    {
        $sectionGroupOperations = (new UserSectionGroupOperationModel())->byUserId($this->getId())->findAll();

        // @TODO

        return [];
    }
}