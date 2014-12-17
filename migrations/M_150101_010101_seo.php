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
		$attributes = array(
			"t.name"        => "Название 1",
			"t.url"         => "url-1",
			"t.title"       => "Заголовок 1",
			"t.keywords"    => "Ключевые слова 1",
			"t.description" => "Описание 1",
		);
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = array(
			"t.name"        => "Название 2",
			"t.url"         => "url-2",
			"t.title"       => "Заголовок 2",
			"t.keywords"    => "Ключевые слова 2",
			"t.description" => "Описание 2",
		);
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = array(
			"t.name"        => "Название 3",
		);
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}