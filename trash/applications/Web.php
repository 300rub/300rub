<?php

//
//	/**
//	 * Script start time
//	 *
//	 * @var int
//	 */
//	private $_startTime = 0;
//
//	/**
//	 * User's model
//	 *
//	 * @var UserModel | null
//	 */
//	public $user = null;
//
//	/**
//	 * Is AJAX request
//	 *
//	 * @var bool
//	 */
//	public $isAjax = false;
//
//	/**
//	 * Active host
//	 *
//	 * @var string
//	 */
//	public $host = "";
//
//	/**
//	 * Runs application
//	 *
//	 * @return void
//	 */
//	public function run()
//	{
//		try {
//			session_start();
//			$this->_startTime = microtime(true);
//			$this->_setSite()->_setUser()->_runController();
//		} catch (Exception $e) {
//			$controller = new CommonController();
//
//			if ($this->config->isDebug) {
//				$message = $e->getMessage();
//			} else {
//				$message = Language::t("common", "error");
//			}
//
//			$controller->actionError($message, $e->getCode());
//		}
//	}
//
//	/**
//	 * Sets current user
//	 *
//	 * @return Web
//	 */
//	private function _setUser()
//	{
//		if (!empty($_SESSION["__u"])) {
//			$this->user = $_SESSION["__u"];
//		} else if (!empty($_COOKIE["__lp"])) {
//			list($login, $password) = explode("|p", $_COOKIE["__lp"], 2);
//			$model = UserModel::model()->findByLogin($login);
//			if ($model !== null && $model->password === $password) {
//				$_SESSION["__u"] = $model;
//				$this->user = $model;
//			}
//		}
//
//		return $this;
//	}
//
//	/**
//	 * Sets site
//	 *
//	 * @throws CommonException
//	 * @throws DbException
//	 *
//	 * @return Web
//	 */
//	private function _setSite()
//	{
//		$host = $_SERVER['HTTP_HOST'];
//
//		if (substr($host, 0, 4) == "www.") {
//			$host = substr($host, 4);
//		}
//
//		if (!$host) {
//			throw new CommonException("Unable to determine the host of the site");
//		}
//
//		$site = Db::fetch("SELECT" . " * FROM sites WHERE host = ?", [$host]);
//		if (!$site) {
//			throw new CommonException(
//				"Unable to find the site with the host: {host}",
//				[
//					"host" => $host
//				]
//			);
//		}
//
//		$this->host = $host;
//		App::web()->config->siteId = $site["id"];
//
//		if ($site["ssh"] && array_key_exists($site["ssh"], App::web()->config->ssh->list)) {
//			App::web()->config->ssh->active = $site["ssh"];
//		}
//
//		Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"]);
//
//		Language::setActiveId($site["language"]);
//
//		return $this;
//	}
//
//	/**
//	 * Runs controller
//	 */
//	private function _runController()
//	{
//		$params = [];
//
//		$explodeForGet = explode("?", $_SERVER["REQUEST_URI"], 2);
//		foreach (explode("/", $explodeForGet[0]) as $param) {
//			if ($param) {
//				$params[] = $param;
//			}
//		}
//
//		if (empty($params[0]) || $params[0] != "ajax") {
//			$this->_runSite($params);
//		} else {
//			$this->_runAjax();
//		}
//
//		exit();
//	}
//
//	/**
//	 * Runs ajax
//	 */
//	private function _runAjax()
//	{
//		sleep(1);
//
//		$useTransaction = false;
//
//		try {
//			$controllerParams = explode(AbstractController::ACTION_SEPARATOR, $input->action);
//			if (count($controllerParams) !== 2) {
//				throw new ContentException("Incorrect \"action\" parameter");
//			}
//
//

//
//			/**
//			 * @var \testS\controllers\AbstractController $controller
//			 */

//
//			if (!$controller->hasAccess($methodName)) {
//				throw new AccessException(
//					"Access denied for the method {methodName}",
//					[
//						"methodName" => $methodName
//					]
//				);
//			}
//
//			Language::setIdByAlias($input->language);
//			$controller->data = json_decode(json_encode($input->fields), true);
//
//			if (isset($controller->data["id"]) && count($controller->data) > 1) {
//				$useTransaction = true;
//				Db::startTransaction();
//			}
//
//			$controller->$methodName();
//			$json = $controller->json;
//
//			if ($useTransaction === true) {
//				Db::commitTransaction();
//			}
//		} catch (Exception $e) {
//			if ($useTransaction === true) {
//				Db::rollbackTransaction();
//			}
//
//			if ($this->config->isDebug) {
//				$message = $e->getMessage();
//			} else {
//				$message = Language::t("common", "error");
//			}
//
//			http_response_code($e->getCode());
//			$json = [
//				"error" => $message
//			];
//		}
//
//		if ($this->config->isDebug) {
//			$json["time"] = number_format(microtime(true) - $this->_startTime, 3);
//		}
//
//		header('Content-Type: application/json');
//		echo json_encode($json);
//	}
//
//	/**
//	 * Runs site
//	 *
//	 * @param $params
//	 *
//	 * @return void
//	 */
//	private function _runSite($params)
//	{
//		if (!empty($params[0])) {
//			Language::setIdByAlias($params[0]);
//		}
//		(new CommonController)->actionStructure(!empty($params[1]) ? $params[1] : null);
//	}
//}