<?php

namespace testS\components;

use PDO;
use PDOStatement;
use testS\applications\App;
use testS\components\exceptions\DbException;
use testS\models\AbstractModel;

/**
 * Class for working with DB
 *
 * @package testS\components
 */
class Db
{

    /**
     * Separator
     */
    const SEPARATOR = "_";

    /**
     * Default alias
     */
    const DEFAULT_ALIAS = "t";

    /**
     * Join types
     */
    const JOIN_TYPE_INNER = "INNER";

    /**
     * PDO model
     *
     * @var PDO
     */
    private static $_pdo;

    /**
     * Select
     *
     * @var array
     */
	private $_select = [];

    /**
     * Table
     *
     * @var string
     */
    private $_table = "";

    /**
     * Where
     *
     * @var string
     */
    private $_where = "";

    /**
     * Join
     *
     * @var string[]
     */
    private $_join = [];

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
     * Fields
     *
     * @var string[]
     */
    private $_fields = [];

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
     * Sets system PDO
     */
    public static function setSystemPdo()
    {
        $app = App::getInstance();

        self::setPdo(
            $app->getConfig(["db", "system", "host"]),
            $app->getConfig(["db", "system", "user"]),
            $app->getConfig(["db", "system", "password"]),
            $app->getConfig(["db", "system", "name"])
        );
    }

    /**
     * Sets localhost PDO
     */
    public static function setLocalhostPdo()
    {
        $app = App::getInstance();

        self::setPdo(
            $app->getConfig(["db", "localhost", "host"]),
            $app->getConfig(["db", "localhost", "user"]),
            $app->getConfig(["db", "localhost", "password"]),
            $app->getConfig(["db", "localhost", "name"])
        );
    }

    /**
     * Resets select
     *
     * @return Db
     */
    public function resetSelect()
    {
        $this->_select = [];
        return $this;
    }

    /**
     * Sets select
     *
     * @param string $field
     * @param string $alias
     *
     * @return Db
     */
    public function addSelect($field, $alias = self::DEFAULT_ALIAS)
    {
        $selectItem = sprintf("%s.%s AS %s_%s", $alias, $field, $alias, $field);

        if (!in_array($selectItem, $this->_select)) {
            $this->_select[] = $selectItem;
        }

        return $this;
    }

    /**
     * Gets select
     *
     * @return array
     */
    public function getSelect()
    {
        return $this->_select;
    }

    /**
     * Sets table
     *
     * @param string $table
     *
     * @return Db
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
    public function getTable()
    {
        return $this->_table;
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
     * Clears where
     *
     * @return Db
     */
    private function _clearWhere()
    {
        $this->_where = "";
        return $this;
    }

    /**
     * Add WHERE condition
     *
     * @param string $where
     * @param string $operator
     *
     * @return Db
     */
    public function addWhere($where, $operator = "AND")
    {
        if ($this->getWhere()) {
            $this->setWhere(
                sprintf(
                    "(%s) %s %s",
                    $this->getWhere(),
                    $operator,
                    $where
                )
            );
        } else {
            $this->setWhere($where);
        }

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
     * @return Db
     */
    public function resetJoin()
    {
        $this->_join = [];
        return $this;
    }

    /**
     * Adds join condition
     *
     * @param string $joinTableName
     * @param string $joinAlias
     * @param string $tableAlias
     * @param string $tableField
     * @param string $type
     * @param string $joinField
     *
     * @return Db
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
            "%s JOIN %s AS %s ON %s.%s = %s.%s",
            $type,
            $joinTableName,
            $joinAlias,
            $joinAlias,
            $joinField,
            $tableAlias,
            $tableField
        );

        if (!in_array($join, $this->_join)) {
            $this->_join[] = $join;
        }

        return $this;
    }

    /**
     * Gets join
     *
     * @return string[]
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
     * Clears parameters
     * 
     * @return Db
     */
    private function _clearParameters()
    {
        $this->_parameters = [];
        return $this;
    }

    /**
     * Adds parameter
     *
     * @param $key
     * @param $value
     *
     * @return Db
     *
     * @throws DbException
     */
    public function addParameter($key, $value) {
        $this->_parameters[$key] = $value;
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
     * Clears fields
     *
     * @return Db
     */
    private function _clearFields()
    {
        $this->_fields = [];
        return $this;
    }

    /**
     * Adds field
     *
     * @param $field
     *
     * @return Db
     *
     * @throws DbException
     */
    public function addField($field) {
        if (!in_array($field, $this->_fields)) {
            $this->_fields[] = $field;
        }

        return $this;
    }

    /**
     * Gets fields
     *
     * @return string[]
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * Gets query
     * 
     * @return string
     */
    private function _getQuery()
    {
        $query = sprintf(
            "SELECT" . " %s FROM %s AS %s",
            implode(",", $this->getSelect()),
            $this->getTable(),
            self::DEFAULT_ALIAS
        );

        if (count($this->getJoin()) > 0) {
            $query .= sprintf(" %s", implode(" ", $this->getJoin()));
        }

        if ($this->getWhere()) {
            $query .= sprintf(" WHERE %s", $this->getWhere());
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
            throw new DbException(
                sprintf(
                    "Unable to execute sql query. Error info: %s",
                    implode(" ,", $sth->errorInfo())
                )
            );
        }

        return $sth;
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
     * Starts transaction
     *
     * @throws DbException
     */
    public static function startTransaction()
    {
        if (self::$_pdo->beginTransaction() === false) {
            throw new DbException(
                sprintf(
                    "Unable to start transaction. Error info: %s",
                    implode(" ,", self::$_pdo->errorInfo())
                )
            );
        }
    }

    /**
     * Applies transaction
     *
     * @throws DbException
     */
    public static function commitTransaction()
    {
        if (self::$_pdo->commit() === false) {
            throw new DbException(
                sprintf(
                    "Unable to commit transaction. Error info: %s",
                    implode(" ,", self::$_pdo->errorInfo())
                )
            );
        }
    }

    /**
     * Rollbacks transaction
     *
     * @throws DbException
     */
    public static function rollbackTransaction()
    {
        if (self::$_pdo->rollBack() === false) {
            throw new DbException(
                sprintf(
                    "Unable to rollback transaction. Error info: %s",
                    implode(" ,", self::$_pdo->errorInfo())
                )
            );
        }
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
     * Inserts record to DB
     * If success - returns new ID
     *
     * @throws DbException
     *
     * @return int
     */
    public function insert()
    {
        $values = [];
        foreach ($this->getFields() as $field) {
            $values[] = sprintf(":%s", $field);
        }

        $query = sprintf(
            "INSERT" . " INTO %s (%s) VALUES (%s)",
            $this->getTable(),
            implode(",", $this->getFields()),
            implode(",", $values)
        );
        
        self::execute($query, $this->getParameters());

        return self::$_pdo->lastInsertId();
    }

    /**
     * Updates record
     *
     * @throws DbException
     */
    public function update()
    {
        $sets = [];
        foreach ($this->getFields() as $field) {
            $sets[] = sprintf("%s = :%s", $field, $field);
        }

        $query = sprintf(
            "UPDATE" . " %s SET %s WHERE %s",
            $this->getTable(),
            implode(",", $sets),
            $this->getWhere()
        );

        self::execute($query, $this->getParameters());
    }

    /**
     * Deletes record
     *
     * @throws DbException
     */
    public function delete()
    {
        $query = sprintf(
            "DELETE" . " FROM %s WHERE %s",
            $this->getTable(),
            $this->getWhere()
        );

        self::execute($query, $this->getParameters());
    }

    public function reset()
    {
        $this->_clearFields()->_clearParameters()->_clearWhere();
    }
}