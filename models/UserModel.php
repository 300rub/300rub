<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;

/**
 * Model for working with table "users"
 *
 * @package testS\models
 *
 * @method UserModel find()
 */
class UserModel extends AbstractModel
{

    /**
     * Salt
     */
    const SALT = "saltForUser";

    /**
     * Types
     */
    const TYPE_FULL_ACCESS = 1;

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
            self::TYPE_FULL_ACCESS => Language::t("user", "fullAccess")
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
                self::FIELD_TYPE        => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION  => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 3,
                    Validator::TYPE_MAX_LENGTH => 40,
                ],
                self::FIELD_BEFORE_SAVE => [
                    "setPassword"
                ]
            ],
            "type"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::getTypeList(), self::TYPE_FULL_ACCESS]
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
     * Finds model by login
     *
     * @param string $login Login
     *
     * @return UserModel|null
     */
    public function findByLogin($login)
    {
        $login = trim($login);
        if (!$login) {
            return null;
        }

        $this->getDb()
            ->addWhere("login = :login")
            ->addParameter("login", $login);

        return $this->find();
    }

    /**
     * Sets password
     *
     * @param string $value
     *
     * @return string
     */
    protected function setPassword($value)
    {
        if (mb_strlen($value, "UTF-8") !== self::PASSWORD_HASH_LENGTH) {
            $value = self::createPasswordHash($value);
        }

        return $value;
    }

    /**
     * Gets password hash
     *
     * @param string $password Password
     *
     * @return string
     */
    public static function createPasswordHash($password)
    {
        return sha1(md5($password) . self::SALT);
    }
}