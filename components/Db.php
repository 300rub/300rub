<?php

namespace testS\components;

use PDO;

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
     * Left Join
     *
     * @var string
     */
    private $_leftJoin = "";

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
     * Sets left join
     *
     * @param string $leftJoin
     *
     * @return Db
     */
    public function setLeftJoin($leftJoin)
    {
        $this->_leftJoin = $leftJoin;
        return $this;
    }

    /**
     * Gets left join
     *
     * @return string
     */
    public function getLeftJoin()
    {
        return $this->_leftJoin;
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
}