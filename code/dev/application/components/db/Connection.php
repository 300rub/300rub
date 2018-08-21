<?php

namespace ss\application\components\db;

use ss\application\App;
use ss\application\exceptions\DbException;

/**
 * Class Connection to work with databases
 */
class Connection
{

    /**
     * @var \PDO[]
     */
    private $_pdoList = [];

    /**
     * Gets PDO by DB name
     *
     * @param string $dbName DB name
     *
     * @return \PDO
     *
     * @throws DbException
     */
    public function getPdo($dbName)
    {
        if (array_key_exists($dbName, $this->_pdoList) === false) {
            $pdoFromConfig = $this->_getPdoFromConfig($dbName);
            if ($pdoFromConfig !== null) {
                return $pdoFromConfig;
            }

            throw new DbException(
                'Unable to find DB instance: {dbName}',
                [
                    'dbName' => $dbName
                ]
            );
        }

        return $this->_pdoList[$dbName];
    }

    /**
     * Gets PDO from config
     *
     * @param string $dbName DB name
     *
     * @return null|\PDO
     */
    private function _getPdoFromConfig($dbName)
    {
        $dbConfig = App::getInstance()
            ->getConfig()
            ->getValue(['db', $dbName]);

        if ($dbConfig === null) {
            return null;
        }

        $this->addPdo(
            $dbConfig['host'],
            $dbConfig['user'],
            $dbConfig['password'],
            $dbConfig['name']
        );

        return $this->_pdoList[$dbName];
    }

    /**
     * Adds PDO
     *
     * @param string $host     Host
     * @param string $user     User
     * @param string $password Password
     * @param string $dbName   DB name
     *
     * @return Connection
     */
    public function addPdo($host, $user, $password, $dbName)
    {
        if (array_key_exists($dbName, $this->_pdoList) === true) {
            return $this;
        }

        $this->_pdoList[$dbName] = new \PDO(
            sprintf(
                'mysql:host=%s;dbname=%s;charset=UTF8',
                $host,
                $dbName
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
     * Initiates a transaction
     *
     * @param string $dbName DB name
     *
     * @return Connection
     *
     * @throws DbException
     */
    public function beginTransaction($dbName)
    {
        if ($this->getPdo($dbName)->beginTransaction() === false) {
            throw new DbException(
                'Unable to start transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($dbName)->errorInfo())
                ]
            );
        }

        return $this;
    }

    /**
     * Commits a transaction
     *
     * @param string $dbName DB name
     *
     * @return Connection
     *
     * @throws DbException
     */
    public function commit($dbName)
    {
        if ($this->getPdo($dbName)->commit() === false) {
            throw new DbException(
                'Unable to commit transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($dbName)->errorInfo())
                ]
            );
        }

        return $this;
    }

    /**
     * Rolls back a transaction
     *
     * @param string $dbName DB name
     *
     * @return Connection
     *
     * @throws DbException
     */
    public function rollBack($dbName)
    {
        if ($this->getPdo($dbName)->rollBack() === false) {
            throw new DbException(
                'Unable to rollback transaction. Error info: {info}',
                [
                    'info' => implode(' ,', $this->getPdo($dbName)->errorInfo())
                ]
            );
        }

        return $this;
    }
}
