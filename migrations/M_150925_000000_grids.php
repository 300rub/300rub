<?php

namespace migrations;

use models\GridModel;
use system\db\Migration;

/**
 * Создает таблицу для структуры
 *
 * @package migrations
 */
class M_150925_000000_grids extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"grids",
			[
				"id"         => "pk",
				"section_id" => "integer",
				"block_id"   => "integer",
				"line"       => "integer",
				"x"          => "integer",
				"y"          => "integer",
				"width"      => "integer",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("grids_section_id", "grids", "section_id")) {
			return false;
		}

		if (!$this->createIndex("grids_block_id", "grids", "block_id")) {
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
			"t.section_id" => 1,
			"t.block_id"   => 1,
			"t.line"       => 1,
			"t.x"          => 0,
			"t.y"          => 0,
			"t.width"      => 6,
		];
		$model = new GridModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		$attributes = [
			"t.section_id" => 2,
			"t.block_id"   => 1,
			"t.line"       => 1,
			"t.x"          => 0,
			"t.y"          => 0,
			"t.width"      => 6,
		];
		$model = new GridModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}