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
class M_150101_010101_seo extends Migration {

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
		// Вставка пустой записи
		$model = new SeoModel;
		if ($model->save()) {
			Logger::log("Удалось записать пустую запись", Logger::LEVEL_ERROR, "console.migrations.seo");
			return false;
		}
		if (count($model->errors) != 2) {
			Logger::log(
				"При вставке пустой записи вместо 2 ошибок обнаружено: " . count($model->errors),
				Logger::LEVEL_ERROR,
				"console.migrations.seo"
			);
			return false;
		}

		// Вставка слишком длинных строк
		$model = new SeoModel;
		$model->name = "очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов";
		$model->url =
			"ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov_ochen_dlinnaya_stroka_bolshe_255_simvolov";
		$model->title = "очень длинная строка больше 100 символов, очень длинная строка больше 100 символов,
			очень длинная строка больше 100 символов, очень длинная строка больше 100 символов";
		$model->keywords = "очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов";
		$model->description = "очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов,
			очень длинная строка больше 255 символов, очень длинная строка больше 255 символов";
		if ($model->save()) {
			Logger::log("Удалось записать слишком длинные строки", Logger::LEVEL_ERROR, "console.migrations.seo");
			return false;
		}
		if (count($model->errors) != 5) {
			Logger::log(
				"При вставке длинных записей вместо 5 ошибок обнаружено: " . count($model->errors),
				Logger::LEVEL_ERROR,
				"console.migrations.seo"
			);
			return false;
		}

		return true;
	}
}