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
				"id"        => "pk",
				"type"      => "integer",
				"is_editor" => "boolean",
				"text"      => "text",
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
			"t.is_editor" => 0,
			"t.type"      => 1,
			"t.text"      => "Текстовая страница",
		];
		$model = new TextModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}