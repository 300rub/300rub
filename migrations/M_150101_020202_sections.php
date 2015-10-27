<?php

namespace migrations;

use models\SectionModel;
use system\db\Migration;

/**
 * Создает таблицу sections
 *
 * @package migrations
 */
class M_150101_020202_sections extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"sections",
			[
				"id"              => "pk",
				"seo_id"          => "integer",
				"language"        => "integer",
				"width"           => "integer",
				"is_main"         => "boolean",
				"design_block_id" => "integer"
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("sections_seo_id", "sections", "seo_id")) {
			return false;
		}

		if (!$this->createIndex("sections_language", "sections", "language")) {
			return false;
		}

		if (!$this->createIndex("sections_is_main", "sections", "is_main")) {
			return false;
		}

		if (!$this->createIndex("sections_design_block_id", "sections", "design_block_id")) {
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
		$attributes = [
			"t.seo_id"          => 1,
			"t.language"        => 1,
			"t.width"           => SectionModel::DEFAULT_WIDTH,
			"t.is_main"         => 1,
			"t.design_block_id" => 1,
		];
		$model = new SectionModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = [
			"t.seo_id"          => 2,
			"t.language"        => 1,
			"t.width"           => 1024,
			"t.is_main"         => 0,
			"t.design_block_id" => 2,
		];
		$model = new SectionModel;
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}