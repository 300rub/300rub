<?php

namespace system\web;

use system\base\Application;
use system\db\Db;
use system\base\Exception;
use controllers\CommonController;
use models\UserModel;
use Mobile_Detect;

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
	 * @var float
	 */
	private $_time = 0;

	/**
	 * Модель пользователя
	 *
	 * @var UserModel | null
	 */
	public $user = null;

	/**
	 * Является ли устройство мобильным
	 *
	 * @var bool
	 */
	public $isMobile = false;

	/**
	 * @var int
	 */
	public $sectionId = 0;

	/**
	 * Запускает команду
	 *
	 * @return void
	 */
	public function run()
	{
		session_start();
		$this->_startTime = microtime(true);
		$this->_setSite()->_setUser()->_runController();
	}

	/**
	 * Устанавливает текущего пользователя
	 *
	 * @return Web
	 */
	private function _setUser()
	{
		if (!empty($_SESSION["__u"])) {
			$this->user = $_SESSION["__u"];
		} else if (!empty($_COOKIE["__lp"])) {
			$explode = explode("|p", $_COOKIE["__lp"], 2);
			$model = UserModel::model()->byLogin($explode[0])->find();
			if ($model->password === $explode[1]) {
				$_SESSION["__u"] = $model;
				$this->user = $model;
			}
		}

		return $this;
	}

	/**
	 * Устанавливает сайт
	 *
	 * @throws Exception
	 *
	 * @return Web
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

		$site = Db::fetch("SELECT * FROM sites WHERE host = ?", [$host]);
		if (!$site) {
			throw new Exception(Language::t("default", "Не удалось определить сайт"));
		}

		if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
			throw new Exception(Language::t("default", "Не удалось соединиться с базой данных"));
		}

		Language::$activeId = $site["language"];

		return $this;
	}

	private function _runAjax($params)
	{
		if (empty($params[1])) {
			throw new Exception(Language::t("common", "Не указан язык"), 404);
		}

		if (empty($params[2])) {
			throw new Exception(Language::t("common", "Не указан контроллер"), 404);
		}

		if (empty($params[3])) {
			throw new Exception(Language::t("common", "Не указано действие контроллера"), 404);
		}

		Language::setIdByAlias($params[1]);

		$controllerName = "\\controllers\\" . ucfirst($params[2]) . "Controller";
		$actionName = "action" . ucfirst($params[3]);
		$controller = new $controllerName;
		$controller->$actionName($_POST);

		$this->_time = number_format(microtime(true) - $this->_startTime, 3);

		header('Content-Type: application/json');
		echo json_encode($controller->json);
		exit();
	}

	private function _runSite($params)
	{
		if (!empty($params[0])) {
			Language::setIdByAlias($params[0]);
		}
		(new CommonController)->actionStructure(!empty($params[1]) ? $params[1] : null);

		$this->_time = number_format(microtime(true) - $this->_startTime, 3);

		return $this;
	}

	/**
	 * Запускает контроллео
	 *
	 * Если первым параметром в URL не указан ajax, то запускается контроллер раздела
	 * Ели указан, то запускается указанный контроллер (ajax/ru/controller/action/param1/param2)
	 *
	 * @throws Exception
	 *
	 * @return Web
	 */
	private function _runController()
	{
		$params = [];

		$explodeForGet = explode("?", $_SERVER["REQUEST_URI"], 2);
		foreach (explode("/", $explodeForGet[0]) as $param) {
			if ($param) {
				$params[] = $param;
			}
		}

		if (empty($params[0]) || $params[0] != "ajax") {
			$this->_runSite($params);
		} else {
			$this->_runAjax($params);
		}

		return $this;
	}
}