<?php

namespace system\base;

use system\App;
use controllers\CommonController;

/**
 * Class for handling errors
 *
 * @package system.base
 */
class ErrorHandler
{

	/**
	 * Trace level
	 *
	 * @var int
	 */
	const TRACE_LEVEL = 5;

	/**
	 * Default error status code
	 */
	const DEFAULT_STATUS_CODE = 500;

	/**
	 * Status. Not found
	 */
	const STATUS_NOT_FOUND = 404;

	/**
	 * Status. Access denied
	 */
	const STATUS_ACCESS_DENIED = 403;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_setErrorReporting()->_setExceptionHandler();
	}

	/**
	 * Sets error reporting
	 *
	 * @return ErrorHandler
	 */
	private function _setErrorReporting()
	{
		ini_set("error_reporting", E_ALL);
		ini_set("display_errors", "On");

		return $this;
	}

	/**
	 * Sets exception handler
	 *
	 * @return ErrorHandler
	 */
	private function _setExceptionHandler()
	{
		set_exception_handler([$this, 'handleException']);
		set_error_handler([$this, 'handleError'], error_reporting());

		return $this;
	}

	/**
	 * Handles exceptions
	 *
	 * @param \system\base\Exception $exception
	 *
	 * @return void;
	 */
	public function handleException($exception)
	{
		restore_error_handler();
		restore_exception_handler();

		$statusCode = self::DEFAULT_STATUS_CODE;
		if (!empty($exception->statusCode)) {
			$statusCode = $exception->statusCode;
		}
		$category = "exception.{$statusCode}";

		$message = $exception->__toString();
		if (isset($_SERVER['REQUEST_URI'])) {
			$message .= "\nREQUEST_URI=" . $_SERVER['REQUEST_URI'];
		}

		Logger::log($message, Logger::LEVEL_ERROR, $category);

		if (isset($_SERVER['REQUEST_URI'])) {
			$trace = "";
			if (App::web()->config->isDebug) {
				$message = $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ')';
				$trace = $exception->getTraceAsString();
			} else {
				$message = $exception->getMessage();
			}

			$controller = new CommonController();
			$controller->actionError($message, $statusCode, $trace);
		}
	}

	/**
	 * Handles errors
	 *
	 * @param int    $code    Code
	 * @param string $message Message
	 * @param string $file    File
	 * @param int    $line    Line number
	 *
	 * @return void
	 */
	public function handleError($code, $message, $file, $line)
	{
		if ($code & error_reporting()) {
			restore_error_handler();
			restore_exception_handler();

			$message = "$message ($file:$line)\nStack trace:\n";
			$trace = debug_backtrace();

			if (count($trace) > self::TRACE_LEVEL) {
				$trace = array_slice($trace, self::TRACE_LEVEL);
			}
			foreach ($trace as $i => $t) {
				if (!isset($t['file'])) {
					$t['file'] = 'unknown';
				}
				if (!isset($t['line'])) {
					$t['line'] = 0;
				}
				if (!isset($t['function'])) {
					$t['function'] = 'unknown';
				}
				$message .= "#$i {$t['file']}({$t['line']}): ";
				if (isset($t['object']) && is_object($t['object'])) {
					$message .= get_class($t['object']) . '->';
				}
				$message .= "{$t['function']}()\n";
			}

			Logger::log($message, Logger::LEVEL_ERROR, 'php');

			if (isset($_SERVER['REQUEST_URI'])) {
				$message .= 'REQUEST_URI=' . $_SERVER['REQUEST_URI'];

				$controller = new CommonController();
				$controller->actionError($message);
			}
		}
	}
}