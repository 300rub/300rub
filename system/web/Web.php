<?php

namespace system\web;

use system\base\Application;
use system\db\Db;
use system\base\Exception;
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
	 * Время начала исполнения скрипта
	 *
	 * @var int
	 */
	private $_startTime = 0;

	/**
	 * Запускает команду
	 *
	 * @return void
	 */
	public function run()
	{
		$this->_startTime = microtime(true);

		$this->_setSite();
		$this->_runController();
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

		Language::$activeId = $site["language"];
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
			if (!empty($params[0])) {
				Language::setIdByAlias($params[0]);
			}
			$controller = new SectionController;
			$controller->actionIndex(
				!empty($params[1]) ? $params[1] : null,
				!empty($params[2]) ? $params[2] : null,
				!empty($params[3]) ? $params[3] : null
			);

			$time = number_format(microtime(true) - $this->_startTime, 3);
			if ($this->config->isDebug) {
				echo "<script>console.log(\"Время выполнения скрипта: {$time} сек.\");</script>";
			}

			return true;
		}

		//sleep(1);

		if (empty($params[1])) {
			throw new Exception(Language::t("common", "Не указан язык"), 404);
		}

		if (empty($params[2])) {
			throw new Exception(Language::t("common", "Не указан контроллер"), 404);
		}

		if (empty($params[3])) {
			throw new Exception(Language::t("common", "Не указано действие контроллера"), 404);
		}

		if (!empty($params[1])) {
			Language::setIdByAlias($params[1]);
		}

		$controllerName = "\\controllers\\" . ucfirst($params[2]) . "Controller";
		$actionName = "action" . ucfirst($params[3]);
		$controller = new $controllerName;
		if (!empty($params[4]) && !empty($params[5])) {
			$controller->$actionName($params[4], $params[5]);
		} else if (!empty($params[4])) {
			$controller->$actionName($params[4]);
		} else {
			$controller->$actionName();
		}

		return true;
	}
}