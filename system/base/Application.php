<?php

namespace system\base;

abstract class Application
{

	public $isDebug = false;
	public $rootDir = "";
	public $db = array();

	/**
	 * Подключенные файлы класов
	 *
	 * @var string[]
	 */
	public static $classMap = array();

	abstract public function run();

	public function __construct($config)
	{
		new ErrorHandler();

		$this->isDebug = $config["isDebug"];
		$this->rootDir = $config["rootDir"];
		$this->db = $config["db"];
	}
}