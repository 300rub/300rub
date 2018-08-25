<?php

namespace ss\application\components\db\_abstract;

use ss\application\App;
use ss\application\components\db\Db;
use ss\application\exceptions\DbException;

/**
 * Abstract class to work with DB
 */
abstract class AbstractDb
{

    /**
     * Name postfixes
     */
    const NAME_POSTFIX_WRITE = 'Write';
    const NAME_POSTFIX_READ = 'Read';

    /**
     * Config DB names
     */
    const CONFIG_DB_NAME_SOURCE = 'source';
    const CONFIG_DB_NAME_SYSTEM = 'system';
    const CONFIG_DB_NAME_HELP = 'help';
    const CONFIG_DB_NAME_PHPUNIT = 'phpunit';

    /**
     * Active DB name
     *
     * @var string
     */
    private $_activePdoKey = '';

    /**
     * PDO list
     *
     * @var \PDO[]
     */
    private $_pdoList = [];

    /**
     * Sets active connection
     *
     * @param string $activePdoKey PDO key
     *
     * @return AbstractDb|Db
     */
    public function setActivePdoKey($activePdoKey)
    {
        $this->_activePdoKey = $activePdoKey;
        return $this;
    }

    /**
     * Gets active PDO key
     *
     * @return string
     */
    public function getActivePdoKey()
    {
        return $this->_activePdoKey;
    }

    /**
     * Gets active PDO
     *
     * @return \PDO
     */
    public function getActivePdo()
    {
        return $this->getPdo($this->_activePdoKey);
    }

    /**
     * Adds PDO
     *
     * @param string $host     Host
     * @param string $user     User
     * @param string $password Password
     * @param string $dbName   DB name
     * @param string $key      PDO key
     *
     * @return AbstractDb|Db
     */
    public function addPdo(
        $host,
        $user,
        $password,
        $dbName = null,
        $key = null
    ) {
        if ($key === null) {
            $key = $dbName;
        }

        if (array_key_exists($key, $this->_pdoList) === true) {
            return $this;
        }

        $dbNameDsn = sprintf('dbname=%s;', $dbName);
        if ($dbName === null) {
            $dbNameDsn = '';
        }

        $this->_pdoList[$key] = new \PDO(
            sprintf(
                'mysql:host=%s;%scharset=UTF8',
                $host,
                $dbNameDsn
            ),
            $user,
            $password,
            [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ]
        );

        return $this;
    }

    /**
     * Deletes PDO
     *
     * @param string $key PDO key
     *
     * @return AbstractDb
     */
    public function deletePdo($key)
    {
        if (array_key_exists($key, $this->_pdoList) === true) {
            unset($this->_pdoList[$key]);
        }

        return $this;
    }

    /**
     * Gets PDO by DB name
     *
     * @param string $key PDO key
     *
     * @return \PDO
     *
     * @throws DbException
     */
    public function getPdo($key)
    {
        if (array_key_exists($key, $this->_pdoList) === false) {
            $pdoFromConfig = $this->_getPdoFromConfig($key);
            if ($pdoFromConfig !== null) {
                return $pdoFromConfig;
            }

            throw new DbException(
                'Unable to find DB instance: {key}',
                [
                    'key' => $key
                ]
            );
        }

        return $this->_pdoList[$key];
    }

    /**
     * Gets PDO from config
     *
     * @param string $key PDO key
     *
     * @return null|\PDO
     */
    private function _getPdoFromConfig($key)
    {
        $dbConfig = App::getInstance()
            ->getConfig()
            ->getValue(['db', $key]);

        if ($dbConfig === null) {
            return null;
        }

        $this->addPdo(
            $dbConfig['host'],
            $dbConfig['user'],
            $dbConfig['password'],
            $dbConfig['name']
        );

        return $this->_pdoList[$key];
    }

    /**
     * Sets root PDO
     *
     * @param string $host Host name
     *
     * @return AbstractDb|Db
     */
    public function setRootPdo($host = null)
    {
        if ($host === null) {
            $host = $this->getRandomDbHost();
        }

        $rootUser = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'root', $host]);

        $this->addPdo(
            $host,
            $rootUser['user'],
            $rootUser['password'],
            null,
            $host
        );

        $this->setActivePdoKey($host);

        return $this;
    }

    /**
     * Gets random DB host
     *
     * @return string
     */
    public function getRandomDbHost()
    {
        $hosts = array_keys(
            App::getInstance()->getConfig()->getValue(['db', 'root'])
        );
        shuffle($hosts);

        return $hosts[0];
    }
}
