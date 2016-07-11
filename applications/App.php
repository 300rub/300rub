<?php

namespace applications;

/**
 * Class for running application
 *
 * @package application
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
	 * Test application
	 *
	 * @var Test
	 */
	private static $_test = null;

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
	 * Gets application for working with tests
	 *
	 * @param array $config Config settings
	 *
	 * @return Test
	 */
	public static function test($config = [])
	{
		if (!self::$_test) {
			self::$_test = new Test($config);
		}

		return self::$_test;
	}

	/**
	 * Gets current application
	 *
	 * @return AbstractApplication
	 */
	public static function getApplication()
	{
		if (self::$_web) {
			return self::$_web;
		}

		if (self::$_console) {
			return self::$_console;
		}

		if (self::$_test) {
			return self::$_test;
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

		$filePath = __DIR__ . "/../" . str_replace("\\", "/", $className) . ".php";
		if (file_exists($filePath)) {
			include ($filePath);
		}
		self::$classMap[] = $className;

		return true;
	}
}

spl_autoload_register(['applications\App','autoload']);