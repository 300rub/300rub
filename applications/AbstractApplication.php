<?php

namespace applications;

use components\Db;
use components\ErrorHandler;
use components\Exception;

/**
 * Abstract class for work with application
 *
 * @package application
 */
abstract class AbstractApplication
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
	 * @return AbstractApplication
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
	 * @return AbstractApplication
	 */
	private function _parseConfig($config)
	{
		$this->config = json_decode(json_encode($config));

		return $this;
	}

	/**
	 * Activates vendor autoload
	 *
	 * @return AbstractApplication
	 */
	private function _activateVendorAutoload()
	{
		require_once(__DIR__ . "/../vendors/autoload.php");

		return $this;
	}

	/**
	 * Checks connection with DB
	 *
	 * @return AbstractApplication
	 *
	 * @throws Exception
	 */
	private function _checkDbConnection()
	{
		if (!Db::setPdo($this->config->db->host, $this->config->db->user, $this->config->db->password, $this->config->db->name)) {
			throw new Exception("Unable to connect to database");
		}

		return $this;
	}
}