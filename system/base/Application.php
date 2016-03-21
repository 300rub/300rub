<?php

namespace system\base;

use system\db\Db;
use system\web\Language;

/**
 * Abstract class for work with application
 *
 * @package system.base
 */
abstract class Application
{

	/**
	 * Settings from config
	 *
	 * @var object
	 */
	public $config = null;

	/**
	 * Runs application
	 *
	 * @return void
	 */
	abstract public function run();

	/**
	 * Constructor
	 *
	 * @param array $config Settings from config
	 */
	public function __construct($config)
	{
		$this
			->_setErrorHandler()
			->_parseConfig($config)
			->_activateVendorAutoload()
			->_checkDbConnection();
	}

	/**
	 * Sets Error Handler
	 *
	 * @return Application
	 */
	private function _setErrorHandler()
	{
		new ErrorHandler();

		return $this;
	}

	/**
	 * Parses config settings
	 *
	 * @param array $config Config settings
	 *
	 * @return Application
	 */
	private function _parseConfig($config)
	{
		$this->config = json_decode(json_encode($config));

		return $this;
	}

	/**
	 * Activates vendor autoload
	 *
	 * @return Application
	 */
	private function _activateVendorAutoload()
	{
		require_once(__DIR__ . "/../../vendors/autoload.php");

		return $this;
	}

	/**
	 * Checks connection with DB
	 *
	 * @return Application
	 *
	 * @throws Exception
	 */
	private function _checkDbConnection()
	{
		if (!Db::setPdo($this->config->db->user, $this->config->db->password, $this->config->db->name)) {
			throw new Exception("Unable to connect to database");
		}

		return $this;
	}
}