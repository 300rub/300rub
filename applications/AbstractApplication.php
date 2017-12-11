<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Application
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications;

use testS\components\Db;
use testS\applications\components\ErrorHandler;
use testS\applications\exceptions\NotFoundException;
use testS\applications\components\SuperGlobalVariable;
use testS\applications\components\Language;
use testS\applications\components\Operation;
use testS\applications\components\View;
use testS\applications\components\Memcached;
use testS\models\SiteModel;

/**
 * Abstract class for work with application
 *
 * @category Applications
 * @package  Application
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
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
     * Super-global variable
     *
     * @var SuperGlobalVariable
     */
    private $_superGlobalVariable = null;

    /**
     * Memcached
     *
     * @var Memcached
     */
    private $_memcached = null;

    /**
     * DB
     *
     * @var Db
     */
    private $_db = null;

    /**
     * Language
     *
     * @var Language
     */
    private $_language = null;

    /**
     * Operation
     *
     * @var Operation
     */
    private $_operation = null;

    /**
     * View
     *
     * @var View
     */
    private $_view = null;

    /**
     * Site
     *
     * @var SiteModel
     */
    private $_site = null;

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
            ->_activateVendorAutoload()
            ->_setConfig($config)
            ->_setSuperGlobalVariable()
            ->_setDb()
            ->_setLanguage()
            ->_setOperation()
            ->_setView()
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
     * Activates vendor autoload
     *
     * @return AbstractApplication
     */
    private function _activateVendorAutoload()
    {
        include_once __DIR__ . "/../vendor/autoload.php";

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
     * @param array $path Path for config item
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
     * Sets Super-global variable
     *
     * @return AbstractApplication
     */
    private function _setSuperGlobalVariable()
    {
        $this->_superGlobalVariable = new SuperGlobalVariable();
        return $this;
    }

    /**
     * Gets Super-global variable
     *
     * @return SuperGlobalVariable
     */
    public function getSuperGlobalVariable()
    {
        return $this->_superGlobalVariable;
    }

    /**
     * Sets DB
     *
     * @return AbstractApplication
     */
    private function _setDb()
    {
        $this->_db = new Db();
        return $this;
    }

    /**
     * Gets DB
     *
     * @return Db
     */
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * Sets Language
     *
     * @return AbstractApplication
     */
    private function _setLanguage()
    {
        $this->_language = new Language();
        return $this;
    }

    /**
     * Gets Language
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * Sets Operation
     *
     * @return AbstractApplication
     */
    private function _setOperation()
    {
        $this->_operation = new Operation();
        return $this;
    }

    /**
     * Gets Operation
     *
     * @return Operation
     */
    public function getOperation()
    {
        return $this->_operation;
    }

    /**
     * Sets View
     *
     * @return AbstractApplication
     */
    private function _setView()
    {
        $this->_view = new View();
        return $this;
    }

    /**
     * Gets View
     *
     * @return View
     */
    public function getView()
    {
        return $this->_view;
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

    /**
     * Sets site
     *
     * @param string $hostname Site hostname
     *
     * @return AbstractApplication
     *
     * @throws NotFoundException
     */
    protected function setSite($hostname = null)
    {
        if (APP_ENV === ENV_DEV || $hostname === null) {
            $hostname = DEV_HOST;
        }

        $memcachedKey = "site_" . $hostname;
        $siteModel = $this->getMemcached()->get($memcachedKey);
        if (!$siteModel instanceof SiteModel) {
            $this->getDb()->setSystemPdo();

            $siteModel = (new SiteModel())->byHost($hostname)->find();
            if ($siteModel === null) {
                throw new NotFoundException(
                    "Unable to find site with host: {host}",
                    [
                    "host" => $hostname
                    ]
                );
            }

            $this->getMemcached()->set($memcachedKey, $siteModel);
        }

        $this->getDb()->setPdo(
            $siteModel->get("dbHost"),
            $siteModel->get("dbUser"),
            $siteModel->get("dbPassword"),
            $siteModel->get("dbName")
        );

        $this->getLanguage()->setActiveId($siteModel->get("language"));

        $this->_site = $siteModel;

        return $this;
    }

    /**
     * Gets site
     *
     * @return SiteModel
     */
    public function getSite()
    {
        return $this->_site;
    }
}