<?php

namespace ss\application\instances\_abstract;

use ss\application\components\Db;
use ss\application\components\Config;
use ss\application\components\ErrorHandler;
use ss\application\components\Logger;
use ss\application\components\Validator;
use ss\application\exceptions\NotFoundException;
use ss\application\components\SuperGlobalVariable;
use ss\application\components\Language;
use ss\application\components\Operation;
use ss\application\components\View;
use ss\application\components\Memcached;
use ss\models\_abstract\AbstractModel;
use ss\models\system\SiteModel;

/**
 * Abstract class for work with application
 */
abstract class AbstractApplication
{

    /**
     * Settings from config
     *
     * @var Config
     */
    private $_config = null;

    /**
     * Super-global variable
     *
     * @var SuperGlobalVariable
     */
    private $_superGlobalVariable = null;

    /**
     * Logger
     *
     * @var Logger
     */
    private $_logger = null;

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
     * View
     *
     * @var Validator
     */
    private $_validator = null;

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
        session_start();

        $this
            ->_setConfig($config)
            ->_setSuperGlobalVariable()
            ->_setLogger()
            ->_setDb()
            ->_activateVendorAutoload()
            ->_setLanguage()
            ->_setOperation()
            ->_setView()
            ->_setMemcached()
            ->_setValidator()
            ->_setErrorHandler();
    }

    /**
     * Sets Error Handler
     *
     * @return AbstractApplication
     */
    private function _setErrorHandler()
    {
        $errorHandler = new ErrorHandler();
        $errorHandler
            ->setErrorReporting()
            ->setExceptionHandler();

        return $this;
    }

    /**
     * Activates vendor autoload
     *
     * @return AbstractApplication
     */
    private function _activateVendorAutoload()
    {
        include_once __DIR__ . '/../../../vendor/autoload.php';

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
        $this->_config = new Config($config);

        return $this;
    }

    /**
     * Gets config
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->_config;
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
     * Sets Logger
     *
     * @return AbstractApplication
     */
    private function _setLogger()
    {
        $this->_logger = new Logger();
        return $this;
    }

    /**
     * Gets Logger
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->_logger;
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
     * Sets Validator
     *
     * @return AbstractApplication
     */
    private function _setValidator()
    {
        $this->_validator = new Validator();
        return $this;
    }

    /**
     * Gets Validator
     *
     * @return Validator
     */
    public function getValidator()
    {
        return $this->_validator;
    }

    /**
     * Sets Memcached
     *
     * @return AbstractApplication
     */
    private function _setMemcached()
    {
        $this->_memcached = new Memcached(
            $this->getConfig()->getValue(['memcached', 'host']),
            $this->getConfig()->getValue(['memcached', 'port'])
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
        if ($hostname === null) {
            $hostname = $this->getConfig()->getValue(['domains', 0, 'name']);
        }

        $memcachedKey = 'site_' . str_replace('.', '_', $hostname);
        $siteModel = $this->getMemcached()->get($memcachedKey);
        if ($siteModel instanceof SiteModel === false) {
            $this->getDb()->setSystemPdo();
            $siteModel = $this->_getSiteModel($hostname);
            if ($siteModel === null) {
                throw new NotFoundException(
                    'Unable to find site with host: {host}',
                    [
                    'host' => $hostname
                    ]
                );
            }

            $this->getMemcached()->set($memcachedKey, $siteModel);
        }

        $this->getDb()->setPdo(
            $siteModel->get('dbHost'),
            $siteModel->get('dbUser'),
            $siteModel->get('dbPassword'),
            $siteModel->get('dbName')
        );

        $this->getLanguage()->setActiveId($siteModel->get('language'));

        $this->_site = $siteModel;

        return $this;
    }

    /**
     * Gets SiteModel by hostname
     *
     * @param string $hostname Hostname
     *
     * @return SiteModel|AbstractModel
     */
    private function _getSiteModel($hostname)
    {
        $siteModel = new SiteModel;
        $baseHost = $this->getConfig()->getValue(['host']);
        $baseHostLength = strlen($baseHost);
        $hostnameLength = strlen($hostname);

        if ($hostnameLength > $baseHostLength + 1) {
            $hostnameEnd = substr($hostname, -1 * $baseHostLength);
            if ($hostnameEnd === $baseHost) {
                $name = substr($hostname, 0, -1 * ($baseHostLength + 1));
                return $siteModel->byName($name)->find();
            }
        }

        return $siteModel->byDomain($hostname)->find();
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
