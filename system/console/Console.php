<?php

namespace system\console;

use system\base\Application;
use system\base\Exception;
use system\base\Logger;

/**
 * Class for working with console
 *
 * @package system.console
 */
class Console extends Application
{

	/**
	 * Command's ending
	 */
	const COMMAND_ENDING = "Command";

	/**
	 * List of all commands
	 *
	 * @var string[]
	 */
	private $_commandList = [];

	/**
	 * Current command
	 *
	 * @var string
	 */
	private $_command = "";

	/**
	 * List of command arguments
	 *
	 * @var string[]
	 */
	private $_args = [];

	/**
	 * Runs command
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function run()
	{
		$startTime = microtime(true);

		$this->_setCommandList();
		if (!$this->_parseCommand()) {
			$this->help();
		}

		$className = "\\commands\\" . ucfirst($this->_command) . self::COMMAND_ENDING;
		Logger::log("Выполняется команда \"{$this->_command}\"...", Logger::LEVEL_INFO, "console.run");

		/**
		 * @var Command $class;
		 */
		$class = new $className;
		if ($class->run($this->_args)) {
			Logger::log("Команда успешно выполнена!", Logger::LEVEL_INFO, "console.run");
		} else {
			Logger::log("Ошибка при выполнении команды.", Logger::LEVEL_ERROR, "console.run");
		}

		$time = number_format(microtime(true) - $startTime, 3);
		Logger::log("Время выполнения скрипта: {$time} сек.", Logger::LEVEL_INFO, "console.run");
	}

	/**
	 * Sets list of command
	 *
	 * @throws Exception
	 *
	 * @return Console
	 */
	private function _setCommandList()
	{
		$list = [];
		$dir = __DIR__ . "/../../commands";

		$handle = opendir($dir);
		if (!$handle) {
			throw new Exception("Папку с командами не удалось открыть");
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$list[] = lcfirst(str_replace(self::COMMAND_ENDING . ".php", "", $file));
			}
		}
		closedir($handle);

		if (!$list) {
			throw new Exception("Команды не найдены");
		}

		$this->_commandList = $list;

		return $this;
	}

	/**
	 * Sets command and arguments
	 *
	 * @return bool
	 */
	private function _parseCommand()
	{
		$argv = $_SERVER['argv'];

		if (empty($argv[1]) || $argv[1] === "help" || !in_array($argv[1], $this->_commandList)) {
			return false;
		}
		$this->_command = $argv[1];

		unset($argv[0]);
		unset($argv[1]);
		sort($argv);
		$this->_args = $argv;

		return true;
	}

	/**
	 * Help
	 *
	 * @return void
	 */
	protected function help()
	{
		echo "Доступные команды:";
		foreach ($this->_commandList as $command) {
			echo "\n   {$command}";
		}
		echo "\n";

		exit();
	}
}