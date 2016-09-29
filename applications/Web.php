<?php

namespace applications;

use components\Db;
use components\exceptions\AccessException;
use components\exceptions\CommonException;
use components\exceptions\ContentException;
use components\exceptions\DbException;
use components\Language;
use controllers\CommonController;
use controllers\AbstractController;
use models\UserModel;
use Exception;

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
	 * Active host
	 *
	 * @var string
	 */
	public $host = "";

	/**
	 * Runs application
	 *
	 * @return void
	 */
	public function run()
	{
		try {
			session_start();
			$this->_startTime = microtime(true);
			$this->_setSite()->_setUser()->_runController();
		} catch (Exception $e) {
			$controller = new CommonController();
			
			if ($this->config->isDebug) {
				$message = $e->getMessage();
			} else {
				$message = Language::t("common", "error");
			}
			
			$controller->actionError($message, $e->getCode());
		}
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
	 * @throws CommonException
	 * @throws DbException
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
			throw new CommonException("Unable to determine the host of the site");
		}

		$site = Db::fetch("SELECT" . " * FROM sites WHERE host = ?", [$host]);
		if (!$site) {
			throw new CommonException(
				"Unable to find the site with the host: {host}",
				[
					"host" => $host
				]
			);
		}

		$this->host = $host;
		App::web()->config->siteId = $site["id"];

		if ($site["ssh"] && array_key_exists($site["ssh"], App::web()->config->ssh->list)) {
			App::web()->config->ssh->active = $site["ssh"];
		}

		if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"])) {
			throw new DbException(
				"Unable to connect to database for host: {host}",
				[
					"host" => $host
				]
			);
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
	 */
	private function _runAjax()
	{
		sleep(1);

		$useTransaction = false;

		try {
			if (
				empty($_SERVER['HTTP_X_REQUESTED_WITH'])
				|| strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
			) {
				throw new ContentException("Only AJAX request is allowed");
			}

			$this->isAjax = true;

			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				throw new ContentException("Only POST method is allowed");
			}

			$input = json_decode(file_get_contents('php://input'));

			if (
				empty($input->action)
				|| empty($input->language)
				|| !isset($input->fields)
			) {
				throw new ContentException("Incorrect post data");
			}

			$controllerParams = explode(AbstractController::ACTION_SEPARATOR, $input->action);
			if (count($controllerParams) !== 2) {
				throw new ContentException("Incorrect \"action\" parameter");
			}

			$className = "\\controllers\\" . ucfirst($controllerParams[0]) . "Controller";
			if (!class_exists($className)) {
				throw new CommonException(
					"Class: {className} doesn't exists",
					[
						"className" => $className
					]
				);
			}

			/**
			 * @var \controllers\AbstractController $controller
			 */
			$controller = new $className;
			$methodName = "action" . ucfirst($controllerParams[1]);
			if (!method_exists($controller, $methodName)) {
				throw new CommonException(
					"Method: {methodName} doesn't exist in class: {className}",
					[
						"methodName" => $methodName,
						"className"  => $className
					]
				);
			}

			if (!$controller->hasAccess($methodName)) {
				throw new AccessException(
					"Access denied for the method {methodName}",
					[
						"methodName" => $methodName
					]
				);
			}

			Language::setIdByAlias($input->language);
			$controller->data = json_decode(json_encode($input->fields), true);

			if (isset($controller->data["id"]) && count($controller->data) > 1) {
				$useTransaction = true;
				Db::startTransaction();
			}

			$controller->$methodName();
			$json = $controller->json;

			if ($useTransaction === true) {
				Db::commitTransaction();
			}
		} catch (Exception $e) {
			if ($useTransaction === true) {
				Db::rollbackTransaction();
			}

			if ($this->config->isDebug) {
				$message = $e->getMessage();
			} else {
				$message = Language::t("common", "error");
			}

			http_response_code($e->getCode());
			$json = [
				"error" => $message
			];
		}

		if ($this->config->isDebug) {
			$json["time"] = number_format(microtime(true) - $this->_startTime, 3);
		}

		header('Content-Type: application/json');
		echo json_encode($json);
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
	}
}