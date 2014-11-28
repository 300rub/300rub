<?php

namespace system\db\repository_tables;

use system\db\Migration;

/**
 * Файл класса Migrations.
 *
 * Создает таблицу для хранения списка миграций
 *
 * @package system.db.repository_tables
 */
class Migrations extends Migration {

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"migrations",
			array(
				"id"      => "pk",
				"version" => "string",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		return true;
	}
}