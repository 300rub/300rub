<?php

namespace applications;

use Exception;

/**
 * Class for working with console
 *
 * @package application
 */
class Console extends AbstractApplication
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
	 */
	public function run()
	{
		try {
			$startTime = microtime(true);

			$this->_setCommandList();
			if (!$this->_parseCommand()) {
				$this->help();
				exit();
			}

			$className = "\\commands\\" . ucfirst($this->_command) . self::COMMAND_ENDING;
			$this->output("The command \"{$this->_command}\" has been started");

			/**
			 * @var \commands\AbstractCommand $class;
			 */
			$class = new $className;
			$class->run($this->_args);

			$time = number_format(microtime(true) - $startTime, 3);
			App::console()->output(
				"The command \"{$this->_command}\" has been finished successfully with time: {$time}"
			);
		} catch (Exception $e) {
			$this->output($e->getMessage(), true);
		}
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
		$dir = __DIR__ . "/../commands";

		$handle = opendir($dir);
		if (!$handle) {
			throw new Exception("Unable to open folder with commands");
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$list[] = lcfirst(str_replace(self::COMMAND_ENDING . ".php", "", $file));
			}
		}
		closedir($handle);

		if (!$list) {
			throw new Exception("Commands are not found");
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
	 */
	protected function help()
	{
		$output = "\e[0;32mAvailable commands: \e[0m";

		foreach ($this->_commandList as $command) {
			$output .= "\n  - {$command}";
		}

		exec("echo -e \"\n{$output}\n\"");
	}

	/**
	 * Console output
	 *
	 * @param string $message
	 * @param bool   $isError
	 */
	public function output($message, $isError = false) {
		$output = "\e[0;33m" . date("Y-m-d H:i:s", time());
		if ($isError === false) {
			$output .= " \e[0;32m[success] ";
		} else {
			$output .= " \e[1;31m[error] ";
		}
		$output .= "\e[0m" . $message;

		exec("echo -e \"\n{$output}\"");
	}
}