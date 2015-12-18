<?php

namespace system\console;

use commands\TestCommand;
use system\base\Logger;
use system\db\Db;

/**
 * Abstract class for working with tests
 *
 * @package system.console
 */
abstract class Test
{

	/**
	 * Asserts equals
	 *
	 * @param mixed $expected Expected value
	 * @param mixed $actual   Actual value
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
	 * Checks validation
	 *
	 * @param \system\base\Model $model            Model
	 * @param string[]           $errors           Error names
	 * @param bool               $isBeforeValidate Is run before validate
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
	 * Checks model save
	 *
	 * @param \system\base\Model $model      Model
	 * @param array              $attributes Attributes for comparison
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
	 * Checks model deleting
	 *
	 * @param \system\base\Model $model Model
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