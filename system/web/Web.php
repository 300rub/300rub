<?php

namespace system\web;

use system\base\Application;
use system\db\Db;
use system\base\Exception;
use system\base\Language;
use controllers\SectionController;

/**
 * Файл класса Web.
 *
 * Web приложение
 *
 * @package system.web
 */
class Web extends Application
{

	/**
	 * Запускает команду
	 *
	 * @return void
	 */
	public function run()
	{
		$startTime = microtime(true);

		$this->_setSite();
		$this->_runController();

		$time = number_format(microtime(true) - $startTime, 3);
		if ($this->config->isDebug) {
			echo "<script>console.log(\"Время выполнения скрипта: {$time} сек.\");</script>";
		}
	}

	/**
	 * Устанавливает сайт
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	private function _setSite()
	{
		$host = $_SERVER['HTTP_HOST'];
		if (substr($host, 0, 4) == "www.") {
			$host = substr($host, 4);
		}
		if (!$host) {
			throw new Exception(Language::t("default", "Не удалось определить адрес сайта"));
		}

		$site = Db::fetch("SELECT * FROM sites WHERE host = ?", array($host));
		if (!$site) {
			throw new Exception(Language::t("default", "Не удалось определить сайт"));
		}

		if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
			throw new Exception(Language::t("default", "Не удалось соединиться с базой данных"));
		}
	}

	/**
	 * Запускает контроллео
	 *
	 * Если первым параметром в URL не указан ajax, то запускается контроллер раздела
	 * Ели указан, то запускается указанный контроллер (ajax/ru/controller/action/param1/param2)
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	private function _runController()
	{
		$params = array();

		$explodeForGet = explode("?", $_SERVER["REQUEST_URI"], 2);
		foreach (explode("/", $explodeForGet[0]) as $param) {
			if ($param) {
				$params[] = $param;
			}
		}

		if (empty($params[0]) || $params[0] != "ajax") {
			$controller = new SectionController(!empty($params[0]) ? $params[0] : "", !empty($params[1]) ? $params[1] : "");
			$controller->actionIndex();

			return true;
		}

		if (empty($params[1])) {
			throw new Exception(Language::t("common", "Не указан язык"), 404);
		}

		if (empty($params[2])) {
			throw new Exception(Language::t("common", "Не указан контроллер"), 404);
		}

		if (empty($params[3])) {
			throw new Exception(Language::t("common", "Не указано действие контроллера"), 404);
		}

		$controllerName = "\\controllers\\" . ucfirst($params[2]);
		$actionName = "action" . ucfirst($params[3]);
		$controller = new $controllerName;
		$controller->$actionName();

		return true;
	}
}