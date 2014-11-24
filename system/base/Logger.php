<?php

namespace system\base;

use system\App;

/**
 * Файл класса Logger
 *
 * @package system.base
 */
class Logger
{

	/**
	 * Информация
	 *
	 * @var string
	 */
	const LEVEL_INFO = "info";

	/**
	 * Ошибка
	 *
	 * @var string
	 */
	const LEVEL_ERROR = "error";

	/**
	 * Логирование
	 *
	 * @param string $msg      сообщение
	 * @param string $level    уровень
	 * @param string $category категория
	 *
	 * @return void
	 */
	public static function log($msg, $level = self::LEVEL_INFO, $category = 'application')
	{
		$traces = debug_backtrace();
		$count = 0;
		foreach ($traces as $trace) {
			if (isset($trace['file'], $trace['line'])) {
				$msg .= "\nin " . $trace['file'] . ' (' . $trace['line'] . ')';
				if (++$count >= ErrorHandler::TRACE_LEVEL) {
					break;
				}
			}
		}

		$text = date("Y-m-d H:i:s", time()) . " [{$category}] " . $msg . "\n\n";

		$logFile = App::$rootDir . "logs" . DIRECTORY_SEPARATOR . $level . ".log";
		$fp = @fopen($logFile, 'a');
		@flock($fp, LOCK_EX);
		@fwrite($fp, $text);
		@flock($fp, LOCK_UN);
		@fclose($fp);
	}
}