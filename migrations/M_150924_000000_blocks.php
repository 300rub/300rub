<?php

namespace migrations;

use models\BlockModel;
use system\db\Migration;

/**
 * Создает таблицу для блоков
 *
 * @package migrations
 */
class M_150924_000000_blocks extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"blocks",
			[
				"id"         => "pk",
				"type"       => "integer",
				"name"       => "string",
				"content_id" => "integer",
				"language"   => "integer",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("blocks_type", "blocks", "type")) {
			return false;
		}

		if (!$this->createIndex("blocks_content_id", "blocks", "content_id")) {
			return false;
		}

		if (!$this->createIndex("blocks_language", "blocks", "language")) {
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
			"t.type"       => BlockModel::TYPE_TEXT,
			"t.name"       => "Текст 1",
			"t.content_id" => 1,
			"t.language"   => 1,
		];
		$model = new BlockModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}