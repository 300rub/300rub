<?php

namespace system;

use system\console\Console;

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
	public static $classMap = array();

	/**
	 * Объект приложения для консоли
	 *
	 * @var Console
	 */
	private static $_console = null;

	/**
	 * Получает приложения для консоли
	 *
	 * @param array $config конфиг
	 *
	 * @return Console
	 */
	public static function console($config = array())
	{
		if (!self::$_console) {
			self::$_console = new Console($config);
		}

		return self::$_console;
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

		include(__DIR__ .
			DIRECTORY_SEPARATOR .
			".." .
			DIRECTORY_SEPARATOR .
			str_replace("\\", "/", $className) .
			".php");
		self::$classMap[] = $className;

		return true;
	}
}

spl_autoload_register(array('system\App','autoload'));