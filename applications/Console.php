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
     * Sets command
     *
     * @param string $command
     *
     * @return Console
     */
    public function setCommand($command)
    {
        $this->_command = $command;
        return $this;
    }

	/**
	 * Runs command
	 *
	 * @throws Exception
	 */
	public function run()
	{
		try {
			$startTime = microtime(true);

			$className = "\\commands\\" . ucfirst($this->_command) . self::COMMAND_ENDING;
			$this->output("The command \"{$this->_command}\" has been started");

			/**
			 * @var \commands\AbstractCommand $class;
			 */
			$class = new $className;
			$class->run($this->_args);

			$time = number_format(microtime(true) - $startTime, 3);
			App::console()->output(
				"The command \"{$this->_command}\" has been finished successfully with time: {$time}\n"
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