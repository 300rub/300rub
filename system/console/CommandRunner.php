<?php

namespace system\console;

/**
 * Файл класса CommandRunner.
 *
 * @package system.console
 */
class CommandRunner extends Command
{

	private $_commandList = array();

	const COMMAND_ENDING = "Command";

	private $_command = "";
	private $_args = array();

	/**
	 * Подключенные файлы класов
	 *
	 * @var string[]
	 */
	public static $classMap = array();

	/**
	 * Корневая директория
	 *
	 * @var string
	 */
	public static $rootDir = "";

	/**
	 * Конструктор
	 *
	 * @param string $config путь до файла настроек
	 */
	public function __construct($config)
	{
		$config = require($config);

		self::$rootDir = $config["rootDir"];
		spl_autoload_register(array('system\console\CommandRunner', "autoload"));

		$this->_setCommandList(self::$rootDir . DIRECTORY_SEPARATOR . "commands");
		if (!$this->_parseCommand()) {
			$this->log("Command parse error!");
		}

		self::$config = $config;
		$this->run($this->_args);
	}

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 */
	public function run($args)
	{
		$className = "\\commands\\" . ucfirst($this->_command) . self::COMMAND_ENDING;
		/**
		 * @var Command $class;
		 */
		$class = new $className;
		$class->run($args);
	}

	/**
	 * Устанавливает список комманд
	 *
	 * @param string $dir директория комманд
	 *
	 * @return bool
	 */
	private function _setCommandList($dir)
	{
		$list = array();

		$handle = opendir($dir);
		if (!$handle) {
			$this->log("Commands folder does not open!");
			return false;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$list[] = strtolower(str_replace(self::COMMAND_ENDING . ".php", "", $file));
			}
		}
		closedir($handle);

		if (!$list) {
			$this->log("Commands not found!");
			return false;
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
			$this->help();
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
	}

	/**
	 * Автоматическая загрузка классов
	 *
	 * @param string $className название класса
	 *
	 * @return bool
	 */
	public static function autoload($className)
	{
		if (array_key_exists($className, self::$classMap)) {
			return false;
		}

		include(self::$rootDir . DIRECTORY_SEPARATOR . str_replace("\\", "/", $className) . ".php");
		self::$classMap[] = $className;

		return true;
	}
}