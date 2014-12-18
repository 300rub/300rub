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
}