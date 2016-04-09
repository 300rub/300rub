<?php

namespace components;

use models\AbstractModel;
use PDO;
use PDOException;

/**
 * Class for working with DB
 *
 * @package components
 */
class Db
{

	/**
	 * Table name
	 *
	 * @var string
	 */
	public $tableName = "";

	/**
	 * Conditions (WHERE)
	 *
	 * @var string
	 */
	public $condition = "";

	/**
	 * Parameters
	 *
	 * @var array
	 */
	public $params = [];

	/**
	 * Limit
	 *
	 * @var string
	 */
	public $limit = "";

	/**
	 * Order
	 *
	 * @var string
	 */
	public $order = "";

	/**
	 * Relations
	 *
	 * @var string[]
	 */
	public $with = [];

	/**
	 * Fields for select
	 *
	 * @var string[]
	 */
	public $fields = [];

	/**
	 * Model PDO
	 *
	 * @var PDO
	 */
	private static $_pdo;

	/**
	 * Relations
	 *
	 * @var array
	 */
	public $relations = [];

	/**
	 * Queries
	 *
	 * @var array
	 */
	public static $queries = [];

	/**
	 * Sets PDO
	 *
	 * @param string $user     DB User
	 * @param string $password DB Password
	 * @param string $dbName   DB name
	 *
	 * @return bool
	 */
	public static function setPdo($user, $password, $dbName)
	{
		try {
			self::$_pdo = new PDO(
				"mysql:host=localhost;dbname={$dbName};charset=UTF8",
				$user,
				$password,
				[
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				]
			);
		} catch (PDOException $e) {
			return false;
		}

		return true;
	}

	/**
	 * Gets SQL query
	 *
	 * @return string
	 */
	private function _getQuery()
	{
		$join = [];
		$select = [];

		$select[] = "t.id AS t__id";
		foreach ($this->fields as $field) {
			$select[] = "t.{$field} AS t__{$field}";
		}

		foreach ($this->with as $with) {
			$relation = $this->relations[$with];
			/**
			 * @var AbstractModel $class
			 */
			$class = new $relation[0];
			$select[] = $with . ".id AS {$with}__id";
			foreach (array_keys($class->getRules()) as $field) {
				$select[] = $with . ".{$field} AS {$with}__{$field}";
			}

			$join[] =
				" LEFT JOIN " .
				$class->getTableName() .
				" AS {$with} ON t.{$relation[1]} = {$with}.id";
		}

		$query = "SELECT " . implode(", ", $select);
		$query .= " FROM " . $this->tableName . " AS t";

		foreach ($join as $item) {
			$query .= $item;
		}

		if ($this->condition) {
			$query .= " WHERE {$this->condition}";
		}

		if ($this->limit) {
			$query .= " LIMIT {$this->limit}";
		}

		if ($this->order) {
			$query .= " ORDER BY {$this->order}";
		}

		self::$queries[] = $query;

		return $query;
	}

	/**
	 * Finds ine record
	 *
	 * @return array
	 */
	public function find()
	{
		return self::fetch($this->_getQuery(), $this->params);
	}

	/**
	 * Finds many records
	 *
	 * @return array
	 */
	public function findAll()
	{
		return self::fetchAll($this->_getQuery(), $this->params);
	}

	/**
	 * Adds condition
	 *
	 * @param string $condition Condition
	 * @param string $operator  Operator
	 *
	 * @return bool
	 */
	public function addCondition($condition = "", $operator = "AND")
	{
		if (!$condition) {
			return false;
		}

		if ($this->condition) {
			$this->condition .= " {$operator} {$condition}";
		} else {
			$this->condition = $condition;
		}

		return true;
	}

	/**
	 * Checks table for existence
	 *
	 * @param string $condition Condition
	 * @param array  $params    Parameters
	 *
	 * @return bool
	 */
	public static function execute($condition, $params = [])
	{
		return self::$_pdo->prepare($condition)->execute($params);
	}

	/**
	 * Fetches one record
	 *
	 * @param string $condition Condition
	 * @param array  $params    Parameters
	 *
	 * @return array
	 */
	public static function fetch($condition, $params = [])
	{
		$sth = self::$_pdo->prepare($condition);
		$sth->execute($params);

		return $sth->fetch();
	}

	/**
	 * Fetches many record
	 *
	 * @param string $condition Condition
	 * @param array  $params    Parameters
	 *
	 * @return array
	 */
	public static function fetchAll($condition, $params = [])
	{
		$sth = self::$_pdo->prepare($condition);
		$sth->execute($params);

		return $sth->fetchAll();
	}

	/**
	 * Starts transaction
	 *
	 * @return void
	 */
	public static function startTransaction()
	{
		self::$_pdo->beginTransaction();
	}

	/**
	 * Applies transaction
	 *
	 * @return void
	 */
	public static function commitTransaction()
	{
		self::$_pdo->commit();
	}

	/**
	 * Rollbacks transaction
	 *
	 * @return void
	 */
	public static function rollbackTransaction()
	{
		self::$_pdo->rollBack();
	}

	/**
	 * Inserts record to DB
	 * If success - returns new ID
	 *
	 * @param AbstractModel $model
	 *
	 * @return int
	 */
	public static function insert($model)
	{
		$columns = [];
		$values = [];
		$substitutions = [];

		foreach ($model->getRules() as $field => $value) {
			$columns[] = $field;
			$substitutions[] = "?";
			$values[] = $model->$field;
		}

		$query =
			"INSERT INTO " .
			$model->getTableName() .
			" (" .
			implode(",", $columns) .
			") VALUES (" .
			implode(",", $substitutions) .
			")";
		if (!self::execute($query, $values)) {
			return 0;
		}

		return self::$_pdo->lastInsertId();
	}

	/**
	 * Updates record
	 *
	 * @param AbstractModel $model
	 *
	 * @return bool
	 */
	public static function update($model)
	{
		$sets = [];
		$values = [];

		foreach ($model->getRules() as $field => $value) {
			$sets[] = "{$field} = ?";
			$values[] = $model->$field;
		}

		$values[] = $model->id;

		$query = "UPDATE " . $model->getTableName() . " SET " . implode(",", $sets) . " WHERE id = ?";

		return self::execute($query, $values);
	}

	/**
	 * Deletes record
	 *
	 * @param AbstractModel $model
	 *
	 * @return bool
	 */
	public static function delete($model)
	{
		return self::execute("DELETE FROM " . $model->getTableName() . " WHERE id = ?", [$model->id]);
	}

	/**
	 * Checks for table existence
	 *
	 * @param string $table Table name
	 *
	 * @return bool
	 */
	public static function isTableExists($table)
	{
		try {
			$result = self::$_pdo->query("SELECT 1 FROM {$table} LIMIT 1");
		} catch (PDOException $e) {
			return false;
		}

		return $result !== false;
	}
}