<?php

namespace system\web;

use system\App;
use system\base\Application;
use system\db\Db;
use system\base\Exception;
use controllers\CommonController;
use models\UserModel;

/**
 * Class for working with WEB application
 *
 * @package system.web
 */
class Web extends Application
{

	/**
	 * Script start time
	 *
	 * @var int
	 */
	private $_startTime = 0;

	/**
	 * Time of script executing
	 *
	 * @var float
	 */
	private $_time = 0;

	/**
	 * User's model
	 *
	 * @var UserModel | null
	 */
	public $user = null;

	/**
	 * Is AJAX request
	 *
	 * @var bool
	 */
	public $isAjax = false;

	/**
	 * Runs application
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
	 * Sets current user
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
	 * Sets site
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

	/**
	 * Runs controller
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
			$this->_runAjax();
		}

		exit();
	}

	/**
	 * Runs ajax
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	private function _runAjax()
	{
		if (
			empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			|| strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
		) {
			throw new Exception(Language::t("common", "This is not ajax request"), 404);
		}

		$this->isAjax = true;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			throw new Exception(Language::t("common", "No post"), 404);
		}

		$input = json_decode(file_get_contents('php://input'));

		if (
			empty($input->action)
			|| empty($input->language)
			|| !isset($input->fields)
		) {
			throw new Exception(Language::t("common", "111"), 404);
		}

		$controllerParams = explode(".", $input->action);
		if (count($controllerParams) !== 2) {
			throw new Exception(Language::t("common", "111"), 404);
		}

		$className = "\\controllers\\" . ucfirst($controllerParams[0]) . "Controller";
		if (!class_exists($className)) {
			throw new Exception(Language::t("common", "111"), 404);
		}

		/**
		 * @var \system\web\Controller $controller
		 */
		$controller = new $className;
		$methodName = "action" . ucfirst($controllerParams[1]);
		if (!method_exists($controller, $methodName)) {
			throw new Exception(Language::t("common", $className . $methodName), 404);
		}

		if ($controller->hasAccess($methodName)) {
			throw new Exception(Language::t("common", "111"), 404);
		}

		Language::setIdByAlias($input->language);
		$controller->data = (array)$input->fields;
		$controller->$methodName();

		$this->_time = number_format(microtime(true) - $this->_startTime, 3);

		header('Content-Type: application/json');
		echo json_encode($controller->json);
	}

	/**
	 * Runs site
	 *
	 * @param $params
	 *
	 * @return void
	 */
	private function _runSite($params)
	{
		if (!empty($params[0])) {
			Language::setIdByAlias($params[0]);
		}
		(new CommonController)->actionStructure(!empty($params[1]) ? $params[1] : null);

		$this->_time = number_format(microtime(true) - $this->_startTime, 3);
	}
}