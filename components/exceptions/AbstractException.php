<?php

namespace testS\components\exceptions;

use Exception;

/**
 * Exception class file
 *
 * @package testS\components
 */
abstract class AbstractException extends Exception
{

	/**
	 * Trace level
	 *
	 * @var integer
	 */
	const TRACE_LEVEL = 5;

	/**
	 * Get error code
	 *
	 * @return integer
	 */
	abstract protected function getErrorCode();

	/**
	 * Get log name
	 *
	 * @return string
	 */
	abstract protected function getLogName();

	/**
	 * AbstractException constructor.
	 *
	 * @param string $message
	 * @param array  $parameters
	 */
	public function __construct($message, array $parameters = [])
	{
		foreach ($parameters as $key => $value) {
			if (is_array($value)) {
				$value = json_encode($value);
			}
			$message = str_replace('{' . $key . '}', (string) $value, $message);
		}

		if (
			empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& isset($_SERVER['REQUEST_URI'])
		) {
			$message .= "\nREQUEST_URI = " . $_SERVER['REQUEST_URI'];
		}

		$this->_writeLog($message);

		parent::__construct($message, $this->getErrorCode());
	}

	/**
	 * Write log
	 *
	 * @param string $message
	 */
	private function _writeLog($message)
	{
		$logMessage = "[" . date("Y-m-d H:i:s", time()) . "] " . $message . "\nTrace:";
		$traces = debug_backtrace();
		$count = 0;
		foreach ($traces as $trace) {
			if (!empty($trace['file']) && !empty($trace['line'])) {
				$logMessage .= "\nFile: " . $trace['file'] . '. Line: ' . $trace['line'];
				if (++$count >= self::TRACE_LEVEL) {
					break;
				}
			}
		}

		$logFolder = __DIR__ . "/../../logs";
		if (!file_exists($logFolder)) {
			mkdir($logFolder, 0777);
		}

		$logFile = $logFolder . "/" . $this->getLogName();
		if (file_exists($logFile)) {
			chmod($logFile, 0777);
		}

		$file = @fopen($logFile, "a");
		@flock($file, LOCK_EX);
		@fwrite($file, $logMessage);
		@flock($file, LOCK_UN);
		@fclose($file);
	}
}