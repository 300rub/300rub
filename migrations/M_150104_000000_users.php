<?php

namespace migrations;

use models\UserModel;
use system\db\Migration;

/**
 * Создает таблицу users
 *
 * @package migrations
 */
class M_150104_000000_users extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"users",
			array(
				"id"       => "pk",
				"login"    => "string",
				"password" => "char(40) not null",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("users_login", "users", "login")) {
			return false;
		}

		return true;
	}

	/**
	 * Добавляет тестовую информацию
	 *
	 * @return bool
	 */
	public function insertData()
	{
		$attributes = array(
			"t.login"    => "l",
			"t.password" => "p",
		);
		$model = new UserModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}