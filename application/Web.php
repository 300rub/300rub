<?php

namespace application;

use components\Db;
use components\ErrorHandler;
use components\Exception;
use components\Language;
use controllers\CommonController;
use controllers\AbstractController;
use models\UserModel;

/**
 * Class for working with WEB application
 *
 * @package application
 */
class Web extends AbstractApplication
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
			list($login, $password) = explode("|p", $_COOKIE["__lp"], 2);
			$model = UserModel::model()->findByLogin($login);
			if ($model !== null && $model->password === $password) {
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
			throw new Exception("Unable to determine the address of the site");
		}

		$site = Db::fetch("SELECT * FROM sites WHERE host = ?", [$host]);
		if (!$site) {
			throw new Exception("Unable to determine the site");
		}

		if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
			throw new Exception("Unable to connect to database");
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
			throw new Exception("This is not ajax request", ErrorHandler::STATUS_NOT_FOUND);
		}

		$this->isAjax = true;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			throw new Exception("REQUEST_METHOD is not POST", ErrorHandler::STATUS_NOT_FOUND);
		}

		$input = json_decode(file_get_contents('php://input'));

		if (
			empty($input->action)
			|| empty($input->language)
			|| !isset($input->fields)
		) {
			throw new Exception("Incorrect post data", ErrorHandler::STATUS_NOT_FOUND);
		}

		$controllerParams = explode(AbstractController::ACTION_SEPARATOR, $input->action);
		if (count($controllerParams) !== 2) {
			throw new Exception("Incorrect \"action\" parameter", ErrorHandler::STATUS_NOT_FOUND);
		}

		$className = "\\controllers\\" . ucfirst($controllerParams[0]) . "Controller";
		if (!class_exists($className)) {
			throw new Exception("Class \"$className\" doesn't exists");
		}

		/**
		 * @var \controllers\AbstractController $controller
		 */
		$controller = new $className;
		$methodName = "action" . ucfirst($controllerParams[1]);
		if (!method_exists($controller, $methodName)) {
			throw new Exception("Class \"{$className} {$methodName}\" doesn't exists");
		}

		if (!$controller->hasAccess($methodName)) {
			throw new Exception("Access denied", ErrorHandler::STATUS_ACCESS_DENIED);
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