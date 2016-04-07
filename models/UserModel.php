<?php

namespace models;

/**
 * Model for working with table "users"
 *
 * @package models
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
	 * Login
	 *
	 * @var string
	 */
	public $login = "";

	/**
	 * Password
	 *
	 * @var string
	 */
	public $password = "";

	/**
	 * Remember or not
	 *
	 * @var bool
	 */
	public $is_remember = false;

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"login"       => self::FORM_TYPE_FIELD,
		"password"    => self::FORM_TYPE_FIELD,
		"is_remember" => self::FORM_TYPE_CHECKBOX
	];

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
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"login"    => ["required", "min" => 3, "latinDigitUnderscoreHyphen"],
			"password" => ["required", "min" => 3],
		];
	}

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
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->login = trim($this->login);
		$this->password = trim($this->password);
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

		$this->db->addCondition("t.login = :login");
		$this->db->params["login"] = $login;

		return $this->find();
	}

	/**
	 * Runs before saving
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (mb_strlen($this->password, "UTF-8") != self::PASSWORD_HASH_LENGTH) {
			$this->password = self::createPasswordHash($this->password);
		}

		return parent::beforeSave();
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