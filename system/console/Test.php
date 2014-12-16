<?php

namespace system\console;

use commands\TestCommand;
use system\base\Logger;

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
}