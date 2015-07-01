<?php

namespace system\console;

use commands\TestCommand;
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
	protected function checkValidate($model, $errors = [], $isBeforeValidate = true)
	{
		$model->validate($isBeforeValidate);

		if (!$model->errors && !$errors) {
			return true;
		}

		$notFound = [];
		$notGiven = [];

		/**
		 * @var string[] $types
		 */
		foreach ($errors as $field => $type) {
			if (array_key_exists($field, $model->errors)) {
				if ($model->errors[$field] != $type) {
					$notFound[] = "{$field}.{$type}";
				}
			} else {
				$notFound[] = $field;
			}
		}

		foreach ($model->errors as $field => $type) {
			if (array_key_exists($field, $errors)) {
				if ($errors[$field] != $type) {
					$notGiven[] = "{$field}.{$type}";
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
	public function checkSave($model, $attributes = [])
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

		$errors = [];
		$model = $model->byId($model->id)->withAll()->find();

		foreach ($attributes as $field => $value) {
			$fieldExplode = explode(".", $field, 2);
			$alias = $fieldExplode[0];
			$field = $fieldExplode[1];
			if ($alias === "t") {
				if ($model->$field != $value) {
					$errors[$field] = ["expected" => $value, "actual" => $model->$field];
				}
			} else {
				if ($model->$alias->$field != $value) {
					$errors["{$alias}.{$field}"] = ["expected" => $value, "actual" => $model->$alias->$field];
				}
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

		if (!$model->delete(false) || $model->byId($model->id)->find()) {
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

		/**
		 * @var \system\base\Model $relation
		 */
		foreach ($model->relations() as $relation => $options) {
			if ($model->$relation && $model->$relation->byId($model->$relation->id)->find()) {
				Logger::log(
					"Не удалось удалить связную модель \"{$relation}\" \n		> Класс:     " .
					get_called_class() .
					" \n		> Тест:      " .
					TestCommand::$activeTest,
					Logger::LEVEL_ERROR,
					"console.test.checkDelete"
				);

				Db::rollbackTransaction();
				return false;
			}
		}

		Db::rollbackTransaction();
		return true;
	}
}