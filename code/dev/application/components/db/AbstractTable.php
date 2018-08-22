<?php

namespace ss\application\components\db;

use ss\application\App;
use ss\application\exceptions\DbException;

/**
 * Abstract class to work with tables
 */
abstract class AbstractTable
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
    const JOIN_TYPE_LEFT = 'LEFT';

    /**
     * Where operators
     */
    const WHERE_OPERATOR_AND = 'AND';
    const WHERE_OPERATOR_OR = 'OR';

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
     * Sets table
     *
     * @param string $table Table name
     *
     * @return AbstractTable
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
     * Sets where
     *
     * @param string $where Where condition
     *
     * @return AbstractTable
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
     * @return AbstractTable
     */
    public function addWhere($where, $operator = self::WHERE_OPERATOR_AND)
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
     * Adds join condition
     *
     * @param string $type          Join type
     * @param string $joinTableName Table to join
     * @param string $joinAlias     Alias of table to join
     * @param string $joinField     Join table field
     * @param string $tableAlias    Basic table alias
     * @param string $tableField    Basic table field
     *
     * @return AbstractTable
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
     * Adds parameter
     *
     * @param string $key   Parameter key
     * @param mixed  $value Parameter value
     *
     * @return AbstractTable
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

    /**
     * Executes query
     *
     * @param string $statement  SQL statement
     * @param array  $parameters Parameters
     *
     * @return \PDOStatement
     *
     * @throws DbException
     * @throws \Exception
     */
    public function execute($statement, $parameters = [])
    {
        $dbObject = App::getInstance()->getDb();

        $logger = App::getInstance()->getLogger();
        $logMessage = sprintf(
            'DB: [%s]. Statement: [%s]. Parameters: [%s]',
            $dbObject->getActivePdoKey(),
            $statement,
            json_encode($parameters)
        );

        try {
            $sth = $dbObject->getActivePdo()->prepare($statement);
            $result = $sth->execute($parameters);
        } catch (\Exception $e) {
            $logger->error($logMessage, 'mysql');
            throw $e;
        }

        if ($result === false) {
            throw new DbException($logMessage);
        }

        $logger->debug($logMessage, 'mysql');
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
}
