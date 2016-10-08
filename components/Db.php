<?php

namespace testS\components;

use PDO;
use PDOStatement;
use testS\components\exceptions\DbException;

/**
 * Class for working with DB
 *
 * @package testS\components
 */
class Db
{

    /**
     * PDO model
     *
     * @var PDO
     */
    private static $_pdo;

    /**
     * Select
     *
     * @var string
     */
	private $_select = "";

    /**
     * From
     *
     * @var string
     */
    private $_from = "";

    /**
     * Where
     *
     * @var string
     */
    private $_where = "";

    /**
     * Join
     *
     * @var string
     */
    private $_join = "";

    /**
     * Order
     *
     * @var string
     */
    private $_order = "";

    /**
     * Limit
     *
     * @var string
     */
    private $_limit = "";

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
     */
    public static function setPdo($host, $user, $password, $dbName)
    {
        self::$_pdo = new PDO(
            "mysql:host={$host};dbname={$dbName};charset=UTF8",
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ]
        );
    }

    /**
     * Sets select
     *
     * @param string $select
     *
     * @return Db
     */
    public function setSelect($select)
    {
        $this->_select = $select;
        return $this;
    }

    /**
     * Gets select
     *
     * @return string
     */
    public function getSelect()
    {
        return $this->_select;
    }

    /**
     * Sets from
     *
     * @param string $from
     *
     * @return Db
     */
    public function setFrom($from)
    {
        $this->_from = $from;
        return $this;
    }

    /**
     * Gets from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->_from;
    }

    /**
     * Sets where
     *
     * @param string $where
     *
     * @return Db
     */
    public function setWhere($where)
    {
        $this->_where = $where;
        return $this;
    }

    /**
     * Gets where
     *
     * @return string
     */
    public function getWhere()
    {
        return $this->_where;
    }

    /**
     * Sets join
     *
     * @param string $join
     *
     * @return Db
     */
    public function setJoin($join)
    {
        $this->_join = $join;
        return $this;
    }

    /**
     * Gets join
     *
     * @return string
     */
    public function getJoin()
    {
        return $this->_join;
    }

    /**
     * Sets order
     *
     * @param string $order
     *
     * @return Db
     */
    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }

    /**
     * Gets order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * Sets limit
     *
     * @param string $limit
     *
     * @return Db
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    /**
     * Gets limit
     *
     * @return string
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * Sets parameters
     * 
     * @param $parameters
     * 
     * @return Db
     */
    public function setParameters($parameters)
    {
        $this->_parameters = $parameters;
        return $this;
    }

    /**
     * Gets parameters
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * Gets query
     * 
     * @return string
     */
    private function _getQuery()
    {
        $query = sprintf("SELECT" . " %s FROM %s", $this->getSelect(), $this->getFrom());
        
        if ($this->getWhere()) {
            $query .= sprintf(" WHERE %s", $this->getWhere());
        }
        
        if ($this->getJoin()) {
            $query .= sprintf(" %s", $this->getJoin());
        }

        if ($this->getOrder()) {
            $query .= sprintf(" ORDER BY %s", $this->getOrder());
        }

        if ($this->getLimit()) {
            $query .= sprintf(" LIMIT %s", $this->getLimit());
        }
        
        return $query;
    }

    /**
     * Fetches one record
     *
     * @param string $statement
     * @param array  $parameters
     *
     * @return array
     */
    public static function fetch($statement, $parameters = [])
    {
        return self::execute($statement, $parameters)->fetch();
    }

    /**
     * Fetches many record
     *
     * @param string $statement
     * @param array  $parameters
     *
     * @return array
     */
    public static function fetchAll($statement, $parameters = [])
    {
        return self::execute($statement, $parameters)->fetchAll();
    }

    /**
     * Finds ine record
     *
     * @return array
     */
    public function find()
    {
        return self::fetch($this->_getQuery(), $this->getParameters());
    }

    /**
     * Finds many records
     *
     * @return array
     */
    public function findAll()
    {
        return self::fetchAll($this->_getQuery(), $this->getParameters());
    }

    /**
     * Executes query
     *
     * @param string $statement
     * @param array  $parameters
     *
     * @return PDOStatement
     *
     * @throws DbException
     */
    public static function execute($statement, $parameters = [])
    {
        $sth = self::$_pdo->prepare($statement);
        $result = $sth->execute($parameters);

        if ($result === false) {
            $errorInfo = [];
            foreach ($sth->errorInfo() as $error) {
                $errorInfo[] = $error;
            }

            throw new DbException(
                sprintf(
                    "Error code: %s. Error info: %s",
                    $sth->errorCode(),
                    implode(" ,", $errorInfo)
                )
            );
        }
        
        return $sth;
    }
}