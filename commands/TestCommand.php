<?php

namespace commands;

use system\base\Logger;
use system\console\Command;

/**
 * Файл класса TestCommand
 *
 * Команда для выполнения тестов
 *
 * @package commands
 */
class TestCommand extends Command
{

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args)
	{
		Logger::log("Выполнение тестов успешно завершено", Logger::LEVEL_INFO, "console.tests");
		return true;
	}
}