<?php

namespace system\console;

use commands\TestCommand;
use system\base\Logger;

abstract class Test {

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
				"console.test"
			);

			return false;
		}

		return true;
	}
}