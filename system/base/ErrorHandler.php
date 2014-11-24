<?php

namespace system\base;

use system\App;
use controllers\ErrorController;

/**
 * Файл класса ErrorHandler
 *
 * @package system.base
 */
class ErrorHandler
{

	/**
	 * Уровень поиска ошибки
	 *
	 * @var integer
	 */
	const TRACE_LEVEL = 3;

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		ini_set("error_reporting", E_ALL);
		ini_set("display_errors", "On");

		set_exception_handler(array($this, 'handleException'));
		set_error_handler(array($this, 'handleError'), error_reporting());
	}

	/**
	 * Обработчик исключений
	 *
	 * @param \system\base\Exception $exception
	 *
	 * @return void;
	 */
	public function handleException($exception)
	{
		restore_error_handler();
		restore_exception_handler();

		$category = 'exception.' . $exception->statusCode;

		$message = $exception->__toString();
		if (isset($_SERVER['REQUEST_URI'])) {
			$message .= "\nREQUEST_URI=" . $_SERVER['REQUEST_URI'];
		}
		if (isset($_SERVER['HTTP_REFERER'])) {
			$message .= "\nHTTP_REFERER=" . $_SERVER['HTTP_REFERER'];
		}

		Logger::log($message, Logger::LEVEL_ERROR, $category);

		$trace = "";
		if (App::$isDebug) {
			$message = $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ')';
			$trace = $exception->getTraceAsString();
		} else {
			$message = $exception->getMessage();
		}

		$controller = new ErrorController();
		$controller->actionError($message, $exception->statusCode, $trace);
	}

	/**
	 * Обработчик ошибок
	 *
	 * @param integer $code    код
	 * @param string  $message сообщение
	 * @param string  $file    файл
	 * @param integer $line    строка
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
			if (isset($_SERVER['REQUEST_URI'])) {
				$message .= 'REQUEST_URI=' . $_SERVER['REQUEST_URI'];
			}

			Logger::log($message, Logger::LEVEL_ERROR, 'php');

			$controller = new ErrorController();
			$controller->actionError($message);
		}
	}
}