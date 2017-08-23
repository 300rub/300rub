<?php

namespace testS\applications;

use testS\components\Db;
use testS\components\ErrorHandler;
use testS\components\exceptions\DbException;
use testS\components\Memcached;

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
	 * @var array
	 */
	private $_config = null;

	/**
	 * Memcached
	 *
	 * @var Memcached
	 */
	private $_memcached = null;

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
            ->_setMemcached();
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
		$this->_config = $config;

		return $this;
	}

	/**
	 * Gets config
	 *
	 * @param array $path
	 *
	 * @return mixed
	 */
	public function getConfig(array $path = [])
	{
		$value = $this->_config;

		if (count($path) === 0) {
			return $value;
		}

		foreach ($path as $item) {
			if (!is_array($value)
				|| !array_key_exists($item, $value)
			) {
				return null;
			}

			$value = $value[$item];
		}

		return $value;
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
	 * Sets Memcached
	 *
	 * @return AbstractApplication
	 */
	private function _setMemcached()
	{
		$this->_memcached = new Memcached(
		    $this->getConfig(["memcached", "host"]),
		    $this->getConfig(["memcached", "port"])
        );

		return $this;
	}

	/**
	 * Gets Memcached
	 *
	 * @return Memcached
	 */
	public function getMemcached()
	{
		return $this->_memcached;
	}
}