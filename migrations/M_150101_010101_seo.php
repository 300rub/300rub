<?php

namespace migrations;

use system\db\Migration;
use models\SeoModel;

/**
 * Creates seo table
 *
 * @package migrations
 */
class M_150101_010101_seo extends Migration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"seo",
			[
				"id"          => "pk",
				"name"        => "string",
				"url"         => "string",
				"title"       => "varchar(100) NOT NULL",
				"keywords"    => "string",
				"description" => "string",
			],
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
	 * Inserts test data
	 *
	 * @return bool
	 */
	public function insertData()
	{
		$attributes = [
			"t.name"        => "Название 1",
			"t.url"         => "url-1",
			"t.title"       => "Заголовок 1",
			"t.keywords"    => "Ключевые слова 1",
			"t.description" => "Описание 1",
		];
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = [
			"t.name"        => "Название 2",
			"t.url"         => "url-2",
			"t.title"       => "Заголовок 2",
			"t.keywords"    => "Ключевые слова 2",
			"t.description" => "Описание 2",
		];
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = [
			"t.name"        => "Название 3",
		];
		$model = new SeoModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}