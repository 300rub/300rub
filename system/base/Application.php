<?php

namespace system\base;

use system\db\Db;

abstract class Application
{

	/**
	 * Настройки
	 *
	 * @var object
	 */
	public $config = null;

	/**
	 * Подключенные файлы класов
	 *
	 * @var string[]
	 */
	public static $classMap = array();

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

		if (!Db::setPdo($this->config->db->user, $this->config->db->password, $this->config->db->name)) {
			throw new Exception(Language::t("common", "Failed to connect to db"));
		}
	}
}