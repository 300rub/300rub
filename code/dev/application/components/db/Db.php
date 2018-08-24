<?php

namespace ss\application\components\db;

use ss\application\App;
use ss\application\exceptions\DbException;

/**
 * Class Connection to work with databases
 */
class Db
{

    /**
     * Path to source dump
     */
    const SOURCE_PATH = CODE_ROOT . '/config/db/source.sql';

    /**
     * Name postfixes
     */
    const NAME_POSTFIX_WRITE = 'Write';
    const NAME_POSTFIX_READ = 'Read';

    /**
     * Config DB names
     */
    const CONFIG_DB_NAME_SYSTEM = 'system';
    const CONFIG_DB_NAME_HELP = 'system';

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
     * Transactions list
     *
     * @var string[]
     */
    private $_transactions = [];

    /**
     * Sets active connection
     *
     * @param string $activePdoKey PDO key
     *
     * @return Db
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
     * @return Db
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
     * @return Db
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
     * Initiates a transaction
     *
     * @param string $key PDO key
     *
     * @return Db
     *
     * @throws DbException
     */
    public function beginTransaction($key)
    {
        if (in_array($key, $this->_transactions) === true) {
            return $this;
        }

        if ($this->getPdo($key)->beginTransaction() === false) {
            throw new DbException(
                'Unable to start transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        $this->_transactions[] = $key;

        return $this;
    }

    /**
     * Commits a transaction
     *
     * @param string $key PDO key
     *
     * @return Db
     *
     * @throws DbException
     */
    public function commit($key)
    {
        if ($this->getPdo($key)->commit() === false) {
            throw new DbException(
                'Unable to commit transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        $transactionKey = array_search($key, $this->_transactions);
        if ($transactionKey !== false) {
            unset($this->_transactions[$transactionKey]);
        }

        return $this;
    }

    /**
     * Commits all transactions
     *
     * @return Db
     */
    public function commitAll()
    {
        foreach ($this->_transactions as $key) {
            $this->commit($key);
        }

        return $this;
    }

    /**
     * Rolls back a transaction
     *
     * @param string $key PDO key
     *
     * @return Db
     *
     * @throws DbException
     */
    public function rollBack($key)
    {
        if ($this->getPdo($key)->rollBack() === false) {
            throw new DbException(
                'Unable to rollback transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($key)->errorInfo())
                ]
            );
        }

        $transactionKey = array_search($key, $this->_transactions);
        if ($transactionKey !== false) {
            unset($this->_transactions[$transactionKey]);
        }

        return $this;
    }

    /**
     * Rolls back all transactions
     *
     * @return Db
     */
    public function rollBackAll()
    {
        foreach ($this->_transactions as $key) {
            $this->rollBack($key);
        }

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

    /**
     * Sets root PDO
     *
     * @param string $host Host name
     *
     * @return Db
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
     * Creates DB
     *
     * @param string $host       Host
     * @param string $user       User
     * @param string $password   Password
     * @param string $dbName     DB name
     * @param string $isRecreate Flag to recreate
     *
     * @return Db
     *
     * @throws DbException
     */
    public function createDb(
        $host,
        $user,
        $password,
        $dbName,
        $isRecreate = null
    ) {
        $rootPdo = $this
            ->setRootPdo($host)
            ->getActivePdo();

        if ($isRecreate === true) {
            $this->dropDb($host, $dbName);
        }

        $sth = $rootPdo->prepare(
            sprintf(
                'CREATE DATABASE IF NOT EXISTS %s',
                $dbName
            )
        );
        $result = $sth->execute();
        if ($result === false) {
            throw new DbException(
                'Unable to create DB {dbName}',
                [
                    'dbName' => $dbName
                ]
            );
        }

        $sth = $rootPdo->prepare(
            sprintf(
                "GRANT ALL ON `%s`.* TO '%s'@'%s' IDENTIFIED BY '%s'",
                $dbName,
                $user,
                $host,
                $password
            )
        );
        $result = $sth->execute();
        if ($result === false) {
            throw new DbException(
                'Unable to create user for DB {dbName}',
                [
                    'dbName' => $dbName
                ]
            );
        }

        return $this;
    }

    /**
     * Drops DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     *
     * @return Db
     *
     * @throws DbException
     */
    public function dropDb($host, $dbName)
    {
        $rootPdo = $this
            ->setRootPdo($host)
            ->getActivePdo();

        $sth = $rootPdo->prepare(
            sprintf(
                'DROP DATABASE IF EXISTS %s',
                $dbName
            )
        );
        $result = $sth->execute();
        if ($result === false) {
            throw new DbException(
                'Unable to drop DB {dbName}',
                [
                    'dbName' => $dbName
                ]
            );
        }

        return $this;
    }

    /**
     * Gets all databases
     *
     * @param string $host Host
     *
     * @return string[]
     *
     * @throws DbException
     */
    public function getAllDbNames($host)
    {
        $rootPdo = $this
            ->setRootPdo($host)
            ->getActivePdo();

        $sth = $rootPdo->prepare('SHOW DATABASES');
        $result = $sth->execute();
        if ($result === false) {
            throw new DbException(
                'Unable to show DBs for host: {host}',
                [
                    'host' => $host
                ]
            );
        }

        $list = [];

        $results = $sth->fetchAll();
        foreach ($results as $item) {
            $list[] = $item['Database'];
        }

        return $list;
    }

    /**
     * Gets DB name for writing
     *
     * @param string $initialDbName Initial DB name
     *
     * @return string
     */
    public function getWriteDbName($initialDbName)
    {
        return $initialDbName . self::NAME_POSTFIX_WRITE;
    }

    /**
     * Gets DB name for reading
     *
     * @param string $initialDbName Initial DB name
     *
     * @return string
     */
    public function getReadDbName($initialDbName)
    {
        return $initialDbName . self::NAME_POSTFIX_READ;
    }

    /**
     * Exports DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     * @param string $path   Path
     *
     * @return Db
     */
    public function exportDb($host, $dbName, $path = null)
    {
        $rootUser = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'root', $host]);

        if ($path === null) {
            $path = sprintf(
                '%s/backups/%s.sql',
                FILES_ROOT,
                $dbName
            );
        }

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s',
                $rootUser['password'],
                $rootUser['user'],
                $host,
                $dbName,
                $path
            )
        );

        return $this;
    }

    /**
     * Exports DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     * @param string $path   Path
     *
     * @return Db
     *
     * @throws DbException
     */
    public function importDb($host, $dbName, $path = null)
    {
        $rootUser = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'root', $host]);

        if ($path === null) {
            $path = sprintf(
                '%s/backups/%s.sql',
                FILES_ROOT,
                $dbName
            );
        }

        if (file_exists($path) === false) {
            throw new DbException(
                'Unable to find the dump file with path: {path}',
                [
                    'path' => $path
                ]
            );
        }

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $rootUser['password'],
                $rootUser['user'],
                $host,
                $dbName,
                $path
            )
        );

        return $this;
    }
}
