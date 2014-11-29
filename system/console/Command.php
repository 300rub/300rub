<?php

namespace system\console;
use system\base\Logger;

/**
 * Файл класса Command.
 *
 * @package system.console
 */
abstract class Command
{

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	abstract public function run($args);

}