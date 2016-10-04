<?php

namespace testS\applications;

use testS\components\exceptions\CommonException;
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
	 * Runs command
	 *
	 * @throws Exception
	 */
	public function run()
	{
		try {
			$startTime = microtime(true);

			$args = $_SERVER['argv'];
			if (empty($args[1])) {
				throw new CommonException("Incorrect command");
			}

			$command = ucfirst($args[1]);
			array_shift($args);
			array_shift($args);

			$className = "\\commands\\" . $command. self::COMMAND_ENDING;
			$this->output("The command \"{$command}\" has been started");

			/**
			 * @var \testS\commands\AbstractCommand $class;
			 */
			$class = new $className;
			$class->run($args);

			$time = number_format(microtime(true) - $startTime, 3);
			App::console()->output(
				"The command \"{$command}\" has been finished successfully with time: {$time}\n"
			);
		} catch (Exception $e) {
			$this->output($e->getMessage() . "\n", true);
		}
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

		echo "\n{$output}";
	}
}