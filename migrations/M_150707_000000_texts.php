<?php

namespace migrations;

use models\TextModel;
use system\db\Migration;

/**
 * Создает таблицу для текстов
 *
 * @package migrations
 */
class M_150707_000000_texts extends Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"texts",
			[
				"id"              => "pk",
				"name"            => "string",
				"language"        => "integer",
				"type"            => "integer",
				"is_editor"       => "boolean",
				"text"            => "text",
				"design_text_id"  => "integer",
				"design_block_id" => "integer",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
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
			"t.name"            => "Текстовый блок",
			"t.language"        => 1,
			"t.is_editor"       => 0,
			"t.type"            => 1,
			"t.text"            => "Текстовая страница",
			"t.design_text_id"  => 1,
			"t.design_block_id" => 3,
		];
		$model = new TextModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}