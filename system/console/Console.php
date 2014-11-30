<?php

namespace system\console;

use system\base\Application;
use system\base\Exception;
use system\base\Logger;

/**
 * Файл класса Console.
 *
 * Приложение для консоли
 *
 * @package system
 */
class Console extends Application
{

	/**
	 * Окончание в название команды
	 */
	const COMMAND_ENDING = "Command";

	/**
	 * Номер релиза
	 *
	 * @var string
	 */
	public $release = "";

	/**
	 * Номер предыдущего релиза
	 *
	 * @var string
	 */
	public $prevRelease = "";

	/**
	 * Список всех команд
	 *
	 * @var string[]
	 */
	private $_commandList = array();

	/**
	 * Запускаемая команда
	 *
	 * @var string
	 */
	private $_command = "";

	/**
	 * Список аргументов команды
	 *
	 * @var string[]
	 */
	private $_args = array();

	/**
	 * Конструктор
	 *
	 * @param array $config конфиг
	 */
	public function __construct($config)
	{
		$this->release = $config["release"];
		$this->prevRelease = $config["prevRelease"];

		parent::__construct($config);
	}

	/**
	 * Запускает команду
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function run()
	{
		$this->_setCommandList();
		if (!$this->_parseCommand()) {
			$this->help();
		}

		$className = "\\commands\\" . ucfirst($this->_command) . self::COMMAND_ENDING;

		/**
		 * @var Command $class;
		 */
		$class = new $className;
		if ($class->run($this->_args)) {
			Logger::log("The command completed successfully", Logger::LEVEL_INFO, "console.run");
		} else {
			Logger::log("Failed to execute command", Logger::LEVEL_ERROR, "console.run");
		}
	}

	/**
	 * Устанавливает список комманд
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	private function _setCommandList()
	{
		$list = array();
		$dir = $this->rootDir . DIRECTORY_SEPARATOR . "commands";

		$handle = opendir($dir);
		if (!$handle) {
			throw new Exception("Commands folder does not open");
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$list[] = strtolower(str_replace(self::COMMAND_ENDING . ".php", "", $file));
			}
		}
		closedir($handle);

		if (!$list) {
			throw new Exception("Commands not found");
		}

		$this->_commandList = $list;
		return true;
	}

	/**
	 * Извлекает команду и аргументы
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
	 * Подсказка
	 *
	 * @return void
	 */
	protected function help()
	{
		echo "Available commands are:";
		foreach ($this->_commandList as $command) {
			echo "\n   {$command}";
		}
		echo "\n";

		exit();
	}
}