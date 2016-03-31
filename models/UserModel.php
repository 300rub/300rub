<?php

namespace models;

use system\base\Model;

/**
 * Model for working with table "users"
 *
 * @package models
 *
 * @method UserModel find()
 */
class UserModel extends Model
{

	/**
	 * Salt
	 */
	const SALT = "saltForUser";

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
			"login"    => ["required"],
			"password" => ["required"],
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
		$this->login = strip_tags($this->login);
		$this->password = strip_tags($this->password);
	}

	/**
	 * Add login condition to SQL request
	 *
	 * @param string $login Login
	 *
	 * @return UserModel
	 */
	public function byLogin($login)
	{
		if (!$login) {
			return $this;
		}

		$this->db->addCondition("t.login = :login");
		$this->db->params["login"] = $login;

		return $this;
	}

	/**
	 * Runs before saving
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (mb_strlen($this->password, "UTF-8") != 40) {
			$this->password = self::getPassword($this->password);
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
	public static function getPassword($password)
	{
		return sha1(md5($password) . self::SALT);
	}
}