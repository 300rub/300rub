<?php

namespace system\base;

use system\db\Db;
use system\web\Language;

abstract class Application
{

	/**
	 * Настройки
	 *
	 * @var object
	 */
	public $config = null;

	/**
	 * Запускает команду
	 *
	 * @return void
	 */
	abstract public function run();

	/**
	 * Конструктор
	 *
	 * @throws Exception
	 *
	 * @param array $config конфиг
	 */
	public function __construct($config)
	{
		new ErrorHandler();

		$this->config = json_decode(json_encode($config));
		require_once($this->config->rootDir . "/vendors/autoload.php");

		if (!Db::setPdo($this->config->db->user, $this->config->db->password, $this->config->db->name)) {
			throw new Exception(Language::t("default", "Не удалось соединиться с базой данных"));
		}
	}
}