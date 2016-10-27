<?php

namespace testS\models;

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
     * Gets model object
     *
     * @return UserModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
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
    protected function getFieldsInfo()
    {
        return [
            "login"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => ["required", "min" => 3, "latinDigitUnderscoreHyphen"],
            ],
            "password" => [
                self::FIELD_TYPE        => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION  => ["required", "min" => 3],
                self::FIELD_BEFORE_SAVE => ["setPassword"]
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