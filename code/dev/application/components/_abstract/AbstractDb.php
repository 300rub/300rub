<?php

namespace ss\application\components\_abstract;

use ss\application\App;
use ss\application\components\Db;
use ss\application\exceptions\DbException;

/**
 * Abstract class for working with DB
 */
abstract class AbstractDb
{

    /**
     * Connection types
     */
    const CONNECTION_TYPE_ROOT = 'root';
    const CONNECTION_TYPE_GUEST = 'guest';
    const CONNECTION_TYPE_ADMIN = 'admin';
    const CONNECTION_TYPE_SYSTEM = 'system';
    const CONNECTION_TYPE_HELP = 'help';

    /**
     * Separator
     */
    const SEPARATOR = '_';

    /**
     * Default alias
     */
    const DEFAULT_ALIAS = 't';

    /**
     * Join types
     */
    const JOIN_TYPE_INNER = 'INNER';
    const JOIN_TYPE_LEFT = 'LEFT';

    /**
     * Connections
     *
     * @var array
     */
    private $_connections = [];

    /**
     * Sets current connection
     *
     * @var string
     */
    private $_currentConnection = '';

    /**
     * Flag to update both DB
     *
     * @var bool
     */
    private $_useMirror = false;

    /**
     * Table
     *
     * @var string
     */
    private $_table = '';

    /**
     * Where
     *
     * @var string
     */
    private $_where = '';

    /**
     * Join
     *
     * @var string[]
     */
    private $_join = [];

    /**
     * Parameters
     *
     * @var array
     */
    private $_parameters = [];

    /**
     * Resets DB
     *
     * @return void
     */
    abstract protected function reset();

    /**
     * Sets update both flag
     *
     * @param bool $useMirror Update both  flag
     *
     * @return AbstractDb
     */
    public function setUseMirror($useMirror)
    {
        $this->_useMirror = (bool)$useMirror;
        return $this;
    }

    /**
     * Sets current connection
     *
     * @param bool $currentConnection Current connection
     *
     * @return AbstractDb
     *
     * @throws DbException
     */
    public function setCurrentConnection($currentConnection)
    {
        if (array_key_exists($currentConnection, $this->_connections) === false) {
            throw new DbException(
                'Unable to find connection: {connection}',
                [
                    'connection' => $currentConnection
                ]
            );
        }

        $this->_currentConnection = $currentConnection;
        return $this;
    }

    /**
     * Gets connections
     *
     * @return array
     */
    protected function getConnections()
    {
        return $this->_connections;
    }

    /**
     * Gets current PDO
     *
     * @return mixed
     */
    protected function getCurrentPdo()
    {
        return $this->_connections[$this->_currentConnection]['pdo'];
    }

    /**
     * Gets current DB name
     *
     * @return mixed
     */
    private function _getCurrentDbName()
    {
        return $this->_connections[$this->_currentConnection]['dbName'];
    }

    /**
     * Gets mirror PDO
     *
     * @return \PDO
     *
     * @throws DbException
     */
    private function _getMirrorPdo()
    {
        return $this->_getMirrorValue('pdo');
    }

    /**
     * Gets mirror DB name
     *
     * @return \PDO
     *
     * @throws DbException
     */
    private function _getMirrorDbName()
    {
        return $this->_getMirrorValue('dbName');
    }

    /**
     * Gets mirror DB name
     *
     * @param string $key Key
     *
     * @return \PDO
     *
     * @throws DbException
     */
    private function _getMirrorValue($key)
    {
        if ($this->_currentConnection === self::CONNECTION_TYPE_GUEST) {
            if (array_key_exists(self::CONNECTION_TYPE_ADMIN, $this->_connections) === false) {
                throw new DbException('Unable to find admin connection');
            }

            return $this->_connections[self::CONNECTION_TYPE_ADMIN][$key];
        }

        if ($this->_currentConnection === self::CONNECTION_TYPE_ADMIN) {
            if (array_key_exists(self::CONNECTION_TYPE_GUEST, $this->_connections) === false) {
                throw new DbException('Unable to find guest connection');
            }

            return $this->_connections[self::CONNECTION_TYPE_GUEST][$key];
        }

        throw new DbException(
            'Connection: {connection} does not have a mirror',
            [
                'connection' => $this->_currentConnection
            ]
        );
    }

    /**
     * Sets system connection
     *
     * @param bool $hasTransaction Transaction flag
     *
     * @return AbstractDb
     */
    public function setSystemConnection($hasTransaction = null)
    {
        $config = App::getInstance()->getConfig();

        $this->setConnection(
            Db::CONNECTION_TYPE_SYSTEM,
            $config->getValue(['db', 'system', 'host']),
            $config->getValue(['db', 'system', 'user']),
            $config->getValue(['db', 'system', 'password']),
            $config->getValue(['db', 'system', 'name']),
            true,
            $hasTransaction
        );

        $this->setCurrentConnection(Db::CONNECTION_TYPE_SYSTEM);

        return $this;
    }

    /**
     * Sets help connection
     *
     * @param bool $hasTransaction Transaction flag
     *
     * @return AbstractDb
     */
    public function setHelpConnection($hasTransaction = null)
    {
        $config = App::getInstance()->getConfig();

        $this->setConnection(
            Db::CONNECTION_TYPE_HELP,
            $config->getValue(['db', 'help', 'host']),
            $config->getValue(['db', 'help', 'user']),
            $config->getValue(['db', 'help', 'password']),
            $config->getValue(['db', 'help', 'name']),
            true,
            $hasTransaction
        );

        $this->setCurrentConnection(Db::CONNECTION_TYPE_HELP);

        return $this;
    }

    /**
     * Sets table
     *
     * @param string $table Table name
     *
     * @return AbstractDb|Db
     */
    public function setTable($table)
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * Gets table
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->_table;
    }

    /**
     * Executes query
     *
     * @param string $statement  SQL statement
     * @param array  $parameters Parameters
     * @param bool   $isMirror   Flag to update both tables
     *
     * @return \PDOStatement
     *
     * @throws DbException
     * @throws \Exception
     */
    public function execute($statement, $parameters = [], $isMirror = null)
    {
        $pdo = $this->getCurrentPdo();
        $dbName = $this->_getCurrentDbName();
        if ($isMirror === true) {
            $pdo = $this->_getMirrorPdo();
            $dbName = $this->_getMirrorDbName();
        }

        $logger = App::getInstance()->getLogger();
        $logMessage = sprintf(
            'DB: [%s]. Statement: [%s]. Parameters: [%s]',
            $dbName,
            $statement,
            json_encode($parameters)
        );

        try {
            $sth = $pdo->prepare($statement);
            $result = $sth->execute($parameters);
            $this->reset();
        } catch (\Exception $e) {
            $logger->error($logMessage, 'mysql');
            $this->reset();

            throw $e;
        }

        if ($result === false) {
            $logger->error($logMessage, 'mysql');

            if ($isMirror !== true) {
                throw new DbException(
                    sprintf(
                        'Unable to execute sql query. Error info: %s',
                        implode(' ,', $sth->errorInfo())
                    )
                );
            }
        }

        $logger->debug($logMessage, 'mysql');

        if ($this->_useMirror === true
            && $isMirror !== true
        ) {
            $this->execute($statement, $parameters, true);
        }

        return $sth;
    }

    /**
     * Fetches one record
     *
     * @param string $statement  SQL statement
     * @param array  $parameters Parameters
     *
     * @return array
     */
    public function fetch($statement, $parameters = [])
    {
        return $this->execute($statement, $parameters)->fetch();
    }

    /**
     * Fetches many record
     *
     * @param string $statement  SQL statement
     * @param array  $parameters Parameters
     *
     * @return array
     */
    public function fetchAll($statement, $parameters = [])
    {
        return $this->execute($statement, $parameters)->fetchAll();
    }

    /**
     * Sets where
     *
     * @param string $where Where condition
     *
     * @return AbstractDb
     */
    public function setWhere($where)
    {
        $this->_where = $where;
        return $this;
    }

    /**
     * Add WHERE condition
     *
     * @param string $where    Where condition
     * @param string $operator Operator(AND / OR)
     *
     * @return AbstractDb
     */
    public function addWhere($where, $operator = 'AND')
    {
        if ($this->getWhere() === '') {
            $this->setWhere($where);
            return $this;
        }

        $this->setWhere(
            sprintf(
                '(%s) %s %s',
                $this->getWhere(),
                $operator,
                $where
            )
        );

        return $this;
    }

    /**
     * Gets where
     *
     * @return string
     */
    protected function getWhere()
    {
        return $this->_where;
    }

    /**
     * Sets join
     *
     * @return AbstractDb
     */
    public function resetJoin()
    {
        $this->_join = [];
        return $this;
    }

    /**
     * Adds join condition
     *
     * @param string $type          Join type
     * @param string $joinTableName Table to join
     * @param string $joinAlias     Alias of table to join
     * @param string $joinField     Join table field
     * @param string $tableAlias    Basic table alias
     * @param string $tableField    Basic table field
     *
     * @return AbstractDb
     */
    public function addJoin(
        $type,
        $joinTableName,
        $joinAlias,
        $joinField,
        $tableAlias,
        $tableField
    ) {
        $join = sprintf(
            '%s JOIN %s AS %s ON %s.%s = %s.%s',
            $type,
            $joinTableName,
            $joinAlias,
            $joinAlias,
            $joinField,
            $tableAlias,
            $tableField
        );

        if (in_array($join, $this->_join) === false) {
            $this->_join[] = $join;
        }

        return $this;
    }

    /**
     * Gets join
     *
     * @return string[]
     */
    protected function getJoin()
    {
        return $this->_join;
    }

    /**
     * Clears parameters
     *
     * @return AbstractDb
     */
    protected function clearParameters()
    {
        $this->_parameters = [];
        return $this;
    }

    /**
     * Adds parameter
     *
     * @param string $key   Parameter key
     * @param mixed  $value Parameter value
     *
     * @return Db|AbstractDb
     *
     * @throws DbException
     */
    public function addParameter($key, $value)
    {
        $this->_parameters[$key] = $value;
        return $this;
    }

    /**
     * Gets parameters
     *
     * @return array
     */
    protected function getParameters()
    {
        return $this->_parameters;
    }
}
