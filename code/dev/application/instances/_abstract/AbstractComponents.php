<?php

namespace ss\application\instances\_abstract;

use ss\application\components\db\Db;
use ss\application\components\common\Config;
use ss\application\components\common\Logger;
use ss\application\components\senders\Email;
use ss\application\components\common\Validator;
use ss\application\components\common\SuperGlobalVariable;
use ss\application\components\common\Language;
use ss\application\components\user\Operation;
use ss\application\components\common\View;
use ss\application\components\common\Memcached;
use ss\application\components\valueGenerator\ValueGenerator;

/**
 * Abstract class for work with components
 */
abstract class AbstractComponents
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
     * ValueGenerator
     *
     * @var ValueGenerator
     */
    private $_valueGenerator = null;

    /**
     * Parses config settings
     *
     * @param array $config Config settings
     *
     * @return AbstractApplication
     */
    protected function setConfig($config)
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
     * Gets Super-global variable
     *
     * @return SuperGlobalVariable
     */
    public function getSuperGlobalVariable()
    {
        if ($this->_superGlobalVariable === null) {
            $this->_superGlobalVariable = new SuperGlobalVariable();
        }

        return $this->_superGlobalVariable;
    }

    /**
     * Gets Logger
     *
     * @return Logger
     */
    public function getLogger()
    {
        if ($this->_logger === null) {
            $this->_logger = new Logger();
        }

        return $this->_logger;
    }

    /**
     * Gets DB
     *
     * @return Db
     */
    public function getDb()
    {
        if ($this->_db === null) {
            $this->_db = new Db();
        }

        return $this->_db;
    }

    /**
     * Gets Language
     *
     * @return Language
     */
    public function getLanguage()
    {
        if ($this->_language === null) {
            $this->_language = new Language();
        }

        return $this->_language;
    }

    /**
     * Gets Operation
     *
     * @return Operation
     */
    public function getOperation()
    {
        if ($this->_operation === null) {
            $this->_operation = new Operation();
        }

        return $this->_operation;
    }

    /**
     * Gets View
     *
     * @return View
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new View();
        }

        return $this->_view;
    }

    /**
     * Gets Validator
     *
     * @return Validator
     */
    public function getValidator()
    {
        if ($this->_validator === null) {
            $this->_validator = new Validator();
        }

        return $this->_validator;
    }

    /**
     * Gets Memcached
     *
     * @return Memcached
     */
    public function getMemcached()
    {
        if ($this->_memcached === null) {
            $this->_memcached = new Memcached(
                $this->getConfig()->getValue(['memcached', 'host']),
                $this->getConfig()->getValue(['memcached', 'port']),
                $this->getConfig()->getValue(['memcached', 'expiration'])
            );
        }

        return $this->_memcached;
    }

    /**
     * Gets Email
     *
     * @return Email
     */
    public function getEmail()
    {
        return new Email();
    }

    /**
     * Gets ValueGenerator
     *
     * @return ValueGenerator
     */
    public function getValueGenerator()
    {
        if ($this->_valueGenerator === null) {
            $this->_valueGenerator = new ValueGenerator();
        }

        return $this->_valueGenerator;
    }
}
