<?php

namespace system\web;

use system\base\Application;
use system\db\Db;
use system\base\Exception;
use system\base\Language;

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

		$time = number_format(microtime(true) - $startTime, 3);
		if ($this->config->isDebug) {
			echo "<script>console.log(\"Время выполнения скрипта: {$time} сек.\");</script>";
		}
	}

	private function _setSite()
	{
		$host = $_SERVER['HTTP_HOST'];
		if (substr($host, 0, 4) == "www.") {
			$host = substr($host, 4);
		}
		if (!$host) {
			throw new Exception(Language::t("common", "Failed to detect host"));
		}

		$site = Db::fetch("SELECT * FROM sites WHERE host = ?", array($host));
		if (!$site) {
			throw new Exception(Language::t("common", "Failed to detect site"));
		}

		if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
			throw new Exception(Language::t("common", "Failed to connect to db"));
		}

		echo 123;
	}
}