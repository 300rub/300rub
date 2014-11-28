<?php

namespace system;

use system\base\Language;
use system\base\Exception;
use system\base\ErrorHandler;
use system\db\Db;
use controllers\SectionController;

/**
 * Файл класса App.
 *
 * Приложение
 *
 * @package system
 */
class App
{

	/**
	 * Установлена ли отладка
	 *
	 * @var bool
	 */
	public static $isDebug = false;

	/**
	 * Подключенные файлы класов
	 *
	 * @var string[]
	 */
	public static $classMap = array();

	/**
	 * Корневая директория
	 *
	 * @var string
	 */
	public static $rootDir = "";

	/**
	 * Базовый URL
	 *
	 * @var string
	 */
	public static $baseUrl = "";

	/**
	 * Запуск приложения
	 *
	 * @param string $config путь до файла настроек
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public static function run($config)
	{
		$startTime = microtime(true);

		ini_set("register_globals", "Off");
		spl_autoload_register(array('system\App', "autoload"));

		$config = require($config);

		self::$isDebug = $config["isDebug"];
		self::$rootDir = $config["rootDir"];
		self::$baseUrl = $config["baseUrl"];

		new ErrorHandler();

		Db::setConnect(
			$config["db"]["host"],
			$config["db"]["user"],
			$config["db"]["password"],
			$config["db"]["base"],
			$config["db"]["charset"]
		);

		$host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);
		$mysqlQuery = mysql_query("SELECT * FROM sites WHERE host = '{$host}'");
		$siteInfo = mysql_fetch_assoc($mysqlQuery);
		if (!$siteInfo) {
			throw new Exception("Site not found");
		}

		Language::setIdByName($siteInfo["lang"]);

		Db::setConnect(
			$config["db"]["host"],
			$siteInfo["db_user"],
			$siteInfo["db_pass"],
			$siteInfo["db_name"],
			$config["db"]["charset"],
			true
		);

		self::_runController(self::_parseUrl($config["baseUrl"]));

		if (self::$isDebug) {
			$time = microtime(true) - $startTime;
			echo "<script>console.log(\"Время выполнения скрипта: {$time} сек.\");</script>";
		}
	}

	/**
	 * Производит запуск контроллера
	 *
	 * @param string[] $params разбитый на куски URL
	 *
	 * @return void
	 */
	private static function _runController($params = array())
	{
		$action = "actionIndex";
		$language = "";
		$section = "";
		$param1 = "";
		$param2 = "";

		if (isset($params[0])) {
			$language = $params[0];
		}

		if (isset($params[1])) {
			$section = $params[1];
		}

		$controller = new SectionController($language, $section, $param1, $param2);
		$controller->$action();
	}

	/**
	 * Разбивает строку
	 *
	 * @param string $baseUrl базовый URL
	 *
	 * @return string[]
	 */
	private static function _parseUrl($baseUrl = "/")
	{
		$items = array();

		$url = substr($_SERVER["REQUEST_URI"], strlen($baseUrl));
		if (!$url) {
			return $items;
		}

		$explodeForGet = explode("?", $url, 2);

		$urlExplode = explode("/", $explodeForGet[0]);
		foreach ($urlExplode as $item) {
			if ($item) {
				$items[] = $item;
			}
		}

		return $items;
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

		include(self::$rootDir . str_replace("\\", "/", $className) . ".php");
		self::$classMap[] = $className;

		return true;
	}
}