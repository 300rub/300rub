<?php

namespace system\console;

/**
 * Файл класса Command.
 *
 * @package system.console
 */
abstract class Command
{

	protected static $config = array();

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	abstract public function run($args);

	public function log($message)
	{
		echo $message;
	}
}