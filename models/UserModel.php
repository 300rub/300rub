<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

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
     * Types
     */
    const TYPE_OWNER = 1;
    const TYPE_ADMINISTRATOR = 2;
    const TYPE_USER = 3;

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
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_OWNER         => "",
            self::TYPE_ADMINISTRATOR => "",
            self::TYPE_USER          => "",
        ];
    }

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
            ],
            "password" => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 40,
                    Validator::TYPE_MAX_LENGTH => 40,
                ]
            ],
            "type"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList(), self::TYPE_USER]
                ]
            ],
            "name"     => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 100,
                ],
            ],
            "email"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_EMAIL,
                ],
            ],
        ];
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