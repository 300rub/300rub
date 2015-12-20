<?php

namespace system;

use system\console\Console;
use system\web\Web;

/**
 * Class for running application
 *
 * @package system
 */
class App
{

	/**
	 * Class map
	 *
	 * @var string[]
	 */
	public static $classMap = [];

	/**
	 * Console application
	 *
	 * @var Console
	 */
	private static $_console = null;

	/**
	 * Web application
	 *
	 * @var Web
	 */
	private static $_web = null;

	/**
	 * Gets application for working with console
	 *
	 * @param array $config Config settings
	 *
	 * @return Console
	 */
	public static function console($config = [])
	{
		if (!self::$_console) {
			self::$_console = new Console($config);
		}

		return self::$_console;
	}

	/**
	 * Gets Application for working with web
	 *
	 * @param array $config Config settings
	 *
	 * @return Web
	 */
	public static function web($config = [])
	{
		if (!self::$_web) {
			self::$_web = new Web($config);
		}

		return self::$_web;
	}

	/**
	 * Gets current application
	 *
	 * @return \system\base\Application
	 */
	public static function getApplication()
	{
		if (self::$_web) {
			return self::$_web;
		}

		if (self::$_console) {
			return self::$_console;
		}

		return null;
	}

	/**
	 * Autoload for all classes
	 *
	 * @param string $className Class name
	 *
	 * @return bool
	 */
	public static function autoload($className)
	{
		if (array_key_exists($className, self::$classMap)) {
			return false;
		}

		include(__DIR__ . DIRECTORY_SEPARATOR .
			".." .
			DIRECTORY_SEPARATOR .
			str_replace("\\", DIRECTORY_SEPARATOR, $className) .
			".php");
		self::$classMap[] = $className;

		return true;
	}
}

spl_autoload_register(['system\App','autoload']);