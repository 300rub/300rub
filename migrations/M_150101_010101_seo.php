<?php

namespace migrations;

use system\base\Logger;
use system\db\Migration;
use models\SeoModel;

/**
 * Файл класса M_150101_010101_seo.
 *
 * Создает таблицу seo
 *
 * @package system.db.repository_tables
 */
class M_150101_010101_seo extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"seo",
			array(
				"id"          => "pk",
				"name"        => "string",
				"url"         => "string",
				"title"       => "varchar(100) NOT NULL",
				"keywords"    => "string",
				"description" => "string",
			),
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("seo_url", "seo", "url")) {
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
		return true;
	}
}