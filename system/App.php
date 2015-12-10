<?php

namespace system;

use system\console\Console;
use system\web\Web;

/**
 * Файл класса App.
 *
 * Выбирает и запускает приложение
 *
 * @package system
 */
class App
{

	/**
	 * Подключенные файлы классов
	 *
	 * @var string[]
	 */
	public static $classMap = [];

	/**
	 * Объект приложения для консоли
	 *
	 * @var Console
	 */
	private static $_console = null;

	/**
	 * Объект web приложения
	 *
	 * @var Web
	 */
	private static $_web = null;

	/**
	 * Получает приложения для консоли
	 *
	 * @param array $config конфиг
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
	 * Получает web приложение
	 *
	 * @param array $config конфиг
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
	 * Получает текущее приложение
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
	 * Автоматическая загрузка классов
	 *
	 * @param string $className название класса
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