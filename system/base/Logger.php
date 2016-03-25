<?php

namespace system\base;

/**
 * Class for working with logging
 *
 * @package system.base
 */
class Logger
{

	/**
	 * Level. Info
	 *
	 * @var string
	 */
	const LEVEL_INFO = "info";

	/**
	 * Level. Error
	 *
	 * @var string
	 */
	const LEVEL_ERROR = "error";

	/**
	 * Default log category
	 */
	const DEFAULT_CATEGORY = "web";

	/**
	 * Logging
	 *
	 * @param string $msg      Message
	 * @param string $level    Level
	 * @param string $category Category
	 *
	 * @return void
	 */
	public static function log($msg, $level = self::LEVEL_INFO, $category = self::DEFAULT_CATEGORY)
	{
		$fileName = $category;
		$categoryList = explode(".", $category, 2);
		if (isset($categoryList[0])) {
			$fileName = $categoryList[0];
		}

		if ($fileName === "console") {
			echo "	> " . date("Y-m-d H:i:s", time()) . " [{$level}] [{$category}] " . $msg . "\n";
		}

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

		$text = date("Y-m-d H:i:s", time()) . " [{$level}] [{$category}] " . $msg . "\n\n";

		$logFile = __DIR__ . "/../../logs/{$fileName}.log";
		$fp = @fopen($logFile, 'a');
		//chmod($logFile, 0777);
		@flock($fp, LOCK_EX);
		@fwrite($fp, $text);
		@flock($fp, LOCK_UN);
		@fclose($fp);
	}
}