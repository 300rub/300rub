<?php

namespace system\db\repository_tables;

use system\db\Migration;

/**
 * Файл класса Sites.
 *
 * Создает таблицу для хранения информации о всех сайтах
 *
 * @package system.db.repository_tables
 */
class Sites extends Migration {

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"sites",
			array(
				"id"          => "pk",
				"host"        => "string",
				"db_host"     => "string",
				"db_user"     => "string",
				"db_password" => "string",
				"db_name"     => "string",
				"language"    => "integer",
				"email"       => "string",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		$result = $this->createIndex("sites_host", "sites", "host");
		if (!$result) {
			return false;
		}

		return true;
	}
}