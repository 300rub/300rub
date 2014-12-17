<?php

namespace system\console;

use commands\TestCommand;
use models\SeoModel;
use system\base\Logger;
use system\db\Db;

abstract class Test
{

	/**
	 * Проверка на совпадение
	 *
	 * @param mixed $expected
	 * @param mixed $actual
	 *
	 * @return bool
	 */
	protected function assertEquals($expected, $actual)
	{
		if ($expected !== $actual) {
			Logger::log(
				"Не совпадают значения \n		> Класс:     " .
				get_called_class() .
				" \n		> Тест:      " .
				TestCommand::$activeTest .
				" \n		> Ожидалось: {$expected} \n		> На деле:   {$actual}",
				Logger::LEVEL_ERROR,
				"console.test.assertEquals"
			);

			return false;
		}

		return true;
	}

	/**
	 * Проверяет валидацию
	 *
	 * @param \system\base\Model $model            модель
	 * @param string[]           $errors           названия ошибок
	 * @param bool               $isBeforeValidate Выполнять ли действия перед валидацией
	 *
	 * @return bool
	 */
	protected function checkValidate($model, $errors = array(), $isBeforeValidate = true)
	{
		$model->validate($isBeforeValidate);

		if (!$model->errors && !$errors) {
			return true;
		}

		$notFound = array();
		$notGiven = array();

		/**
		 * @var string[] $types
		 */
		foreach ($errors as $field => $types) {
			if (array_key_exists($field, $model->errors)) {
				foreach ($types as $type) {
					if (!array_key_exists($type, $model->errors[$field])) {
						$notFound[] = "{$field}.{$type}";
					}
				}
			} else {
				$notFound[] = $field;
			}
		}

		foreach ($model->errors as $field => $types) {
			if (array_key_exists($field, $errors)) {
				foreach ($types as $key => $type) {
					if (!in_array($key, $errors[$field])) {
						$notGiven[] = "{$field}.{$key}";
					}
				}
			} else {
				$notGiven[] = $field;
			}
		}

		if ($notFound || $notGiven) {
			$message =
				"Не прошла валидация \n		> Класс:      " .
				get_called_class() .
				" \n		> Тест:       " .
				TestCommand::$activeTest;
			if ($notFound) {
				$message .= "\n		> Не найдено: " . implode(", ", $notFound);
			}
			if ($notGiven) {
				$message .= "\n		> Не указано: " . implode(", ", $notGiven);
			}
			Logger::log($message, Logger::LEVEL_ERROR, "console.test.checkValidate");

			return false;
		}

		return true;
	}

	/**
	 * Проверяет сохранение модели
	 *
	 * @param \system\base\Model $model      модель
	 * @param array              $attributes атрибуты для сравнения
	 *
	 * @return bool
	 */
	public function checkSave($model, $attributes = array())
	{
		if (!$model) {
			Logger::log(
				"Не удалось получить модель \n		> Класс:     " .
				get_called_class() .
				" \n		> Тест:      " .
				TestCommand::$activeTest,
				Logger::LEVEL_ERROR,
				"console.test.checkSave"
			);

			return false;
		}

		Db::startTransaction();

		if (!$model->save(false)) {
			Logger::log(
				"Не удалось сохранить модель \n		> Класс:     " .
				get_called_class() .
				" \n		> Тест:      " .
				TestCommand::$activeTest,
				Logger::LEVEL_ERROR,
				"console.test.checkSave"
			);

			Db::rollbackTransaction();
			return false;
		}

		$errors = array();
		$model = SeoModel::model()->byId($model->id)->find();

		foreach ($attributes as $field => $value) {
			$fieldExplode = explode(".", $field, 2);
			$field = $fieldExplode[1];
			if ($model->$field !== $value) {
				$errors[$field] = array("expected" => $value, "actual" => $model->$field);
			}
		}

		if (!$errors) {
			Db::rollbackTransaction();
			return true;
		}

		$message =
			"Не совпадают значения модели \n		> Класс:     " .
			get_called_class() .
			" \n		> Тест:      " .
			TestCommand::$activeTest .
			"\n		> Различия:";
		foreach ($errors as $key => $value) {
			$message .= "\n			> {$key}";
			$message .= "\n				- {$value['expected']}";
			$message .= "\n				+ {$value['actual']}";
		}
		Logger::log($message, Logger::LEVEL_ERROR, "console.test.checkInsert");

		Db::rollbackTransaction();
		return false;
	}

	/**
	 * Проверяет удаление модели
	 *
	 * @param \system\base\Model $model модель
	 *
	 * @return bool
	 */
	public function checkDelete($model)
	{
		if (!$model) {
			Logger::log(
				"Не удалось получить модель \n		> Класс:     " .
				get_called_class() .
				" \n		> Тест:      " .
				TestCommand::$activeTest,
				Logger::LEVEL_ERROR,
				"console.test.checkDelete"
			);

			return false;
		}

		Db::startTransaction();

		if (!$model->delete(false) || SeoModel::model()->byId($model->id)->find()) {
			Logger::log(
				"Не удалось удалить модель \n		> Класс:     " .
				get_called_class() .
				" \n		> Тест:      " .
				TestCommand::$activeTest,
				Logger::LEVEL_ERROR,
				"console.test.checkDelete"
			);

			Db::rollbackTransaction();
			return false;
		}

		Db::rollbackTransaction();
		return true;
	}
}