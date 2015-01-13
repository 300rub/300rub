<?php

namespace models;

use system\base\Model;
use system\web\Language;

/**
 * @package models
 *
 * @method UserModel find()
 */
class UserModel extends Model
{

	/**
	 * Логин
	 *
	 * @var string
	 */
	public $login = "";

	/**
	 * Пароль
	 *
	 * @var string
	 */
	public $password = "";

	/**
	 * Запомнить ли при входе
	 *
	 * @var bool
	 */
	public $remember = false;

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = array(
		"login" => "field",
		"password" => "password",
		"remember" => "checkbox",
	);

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "users";
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"login"    => array("required", "max" => 3),
			"password" => array("required"),
		);
	}

	/**
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return array(
			"login"    => Language::t("common", "Логин"),
			"password" => Language::t("common", "Пароль"),
			"remember" => Language::t("common", "Запонить"),
		);
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return UserModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

	/**
	 * Выполняется перед валидацией модели
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->login = strip_tags($this->login);
		$this->password = strip_tags($this->password);
	}

	/**
	 * Поиск по логину
	 *
	 * @param string $login логин
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
	 * Выполняется перед сохранением
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (mb_strlen($this->password, "UTF-8") != 40) {
			$this->password = $this->getPassword($this->password);
		}

		return parent::beforeSave();
	}

	/**
	 * Генерирует зашифрованный пароль
	 *
	 * @param string $password незашифрованный пароль
	 *
	 * @return string
	 */
	public function getPassword($password)
	{
		return sha1(md5($password) . "salt");
	}
}