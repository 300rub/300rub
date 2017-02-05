<?php

namespace testS\applications;

use testS\components\Db;
use testS\components\ErrorHandler;
use testS\components\exceptions\DbException;

/**
 * Abstract class for work with application
 *
 * @package testS\application
 */
abstract class AbstractApplication
{

	/**
	 * Settings from config
	 *
	 * @var object
	 */
	private $_config = null;

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
			->_setConfig($config)
			->_activateVendorAutoload()
			->_setDbConnection();
	}

    /**
     * Gets config
     *
     * @return object
     */
	public function getConfig()
    {
        return $this->_config;
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
	private function _setConfig($config)
	{
		$this->_config = json_decode(json_encode($config));

		return $this;
	}

	/**
	 * Activates vendor autoload
	 *
	 * @return AbstractApplication
	 */
	private function _activateVendorAutoload()
	{
		require_once(__DIR__ . "/../vendor/autoload.php");

		return $this;
	}

	/**
	 * Sets connection with DB
	 *
	 * @return AbstractApplication
	 *
	 * @throws DbException
	 */
	private function _setDbConnection()
	{
		Db::setPdo(
			$this->getConfig()->db->host,
			$this->getConfig()->db->user,
			$this->getConfig()->db->password,
			$this->getConfig()->db->name
		);

		return $this;
	}
}