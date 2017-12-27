<?php

namespace testS\application\components\_abstract;

use testS\application\App;
use testS\application\components\Db;
use testS\application\exceptions\DbException;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract class for working with DB
 */
abstract class AbstractDb
{

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

    /**
     * PDO model
     *
     * @var \PDO
     */
    private $_pdo;

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
     * Sets PDO
     *
     * @param string $host     DB Host
     * @param string $user     DB User
     * @param string $password DB Password
     * @param string $dbName   DB name
     *
     * @return AbstractDb
     */
    public function setPdo($host, $user, $password, $dbName)
    {
        $this->_pdo = new \PDO(
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
     * Gets PDO
     *
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->_pdo;
    }

    /**
     * Sets system PDO
     *
     * @return AbstractDb
     */
    public function setSystemPdo()
    {
        $config = App::getInstance()->getConfig();

        $this->setPdo(
            $config->getValue(['db', 'system', 'host']),
            $config->getValue(['db', 'system', 'user']),
            $config->getValue(['db', 'system', 'password']),
            $config->getValue(['db', 'system', 'name'])
        );

        return $this;
    }

    /**
     * Sets localhost PDO
     *
     * @return AbstractDb
     */
    public function setLocalhostPdo()
    {
        $config = App::getInstance()->getConfig();

        $this->setPdo(
            $config->getValue(['db', 'localhost', 'host']),
            $config->getValue(['db', 'localhost', 'user']),
            $config->getValue(['db', 'localhost', 'password']),
            $config->getValue(['db', 'localhost', 'name'])
        );

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
     *
     * @return \PDOStatement
     *
     * @throws DbException
     */
    public function execute($statement, $parameters = [])
    {
        $sth = $this->getPdo()->prepare($statement);
        $result = $sth->execute($parameters);

        if ($result === false) {
            throw new DbException(
                sprintf(
                    'Unable to execute sql query. Error info: %s',
                    implode(' ,', $sth->errorInfo())
                )
            );
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
     * Clears where
     *
     * @return AbstractDb
     */
    protected function clearWhere()
    {
        $this->_where = '';
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
     * @param string $joinTableName Table to join
     * @param string $joinAlias     Alias of table to join
     * @param string $tableAlias    Basic table alias
     * @param string $tableField    Basic table field
     * @param string $type          Join type
     * @param string $joinField     Join table field
     *
     * @return AbstractDb
     */
    public function addJoin(
        $joinTableName,
        $joinAlias,
        $tableAlias,
        $tableField,
        $type = self::JOIN_TYPE_INNER,
        $joinField = AbstractModel::PK_FIELD
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
