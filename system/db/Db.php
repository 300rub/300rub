<?php

namespace system\db;

use PDO;
use PDOException;
use system\base\Exception;
use system\base\Model;

/**
 * Файл класса Db
 *
 * @package system.db
 */
class Db
{

	/**
	 * Префикс БД
	 */
	const PREFIX = "s_";

	/**
	 * Название таблицы
	 *
	 * @var string
	 */
	public $tableName = "";

	/**
	 * Условия выборки
	 *
	 * @var string
	 */
	public $condition = "";

	/**
	 * Параметры
	 *
	 * @var array
	 */
	public $params = array();

	/**
	 * Лимит
	 *
	 * @var string
	 */
	public $limit = "";

	/**
	 * Связные таблицы
	 *
	 * @var string[]
	 */
	public $with = array();

	/**
	 * Поля для выбора
	 *
	 * @var string[]
	 */
	public $fields = array();

	/**
	 * Модель PDO
	 *
	 * @var PDO
	 */
	private static $_pdo;

	/**
	 * Связи
	 *
	 * @var array
	 */
	public $relations = array();

	/**
	 * Устанавливает PDO
	 *
	 * @param string $user     пользователь
	 * @param string $password парль
	 * @param string $dbName   база
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
				array(
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				)
			);
		} catch (PDOException $e) {
			return false;
		}

		return true;
	}

	/**
	 * Формирует SQL запрос
	 *
	 * @return string
	 */
	private function _getQuery()
	{
		$join = array();
		$select = array();

		$select[] = "t.id AS t__id";
		foreach ($this->fields as $field) {
			$select[] = "t.{$field} AS t__{$field}";
		}

		foreach ($this->with as $with) {
			$relation = $this->relations[$with];
			/**
			 * @var Model $class
			 */
			$class = new $relation[0];
			$select[] = $class->tableName() . ".id AS {$with}__id";
			foreach (array_keys($class->rules()) as $field) {
				$select[] = $class->tableName() . ".{$field} AS {$with}__{$field}";
			}

			$this->condition = str_replace("{$with}.", $class->tableName() . ".", $this->condition);
			$join[] =
				" LEFT JOIN " .
				$class->tableName() .
				" ON t." .
				$relation[1] .
				" = " .
				$class->tableName() .
				".id";
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

		//if (App::$isDebug) {
		//	echo "<script>console.log(\"{$query}\");</script>";
		//}

		return $query;
	}

	/**
	 * Выбирает одну запись
	 *
	 * @return array
	 */
	public function find()
	{
		return self::fetch($this->_getQuery(), $this->params);
	}

	/**
	 * Выбирает несколько записей
	 *
	 * @return array
	 */
	public function findAll()
	{
		return self::fetchAll($this->_getQuery(), $this->params);
	}

	/**
	 * Добавляет условие
	 *
	 * @param string $condition условие
	 * @param string $operator  оператор
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
	 * Проверяет таблицу на существование
	 *
	 * @param string $condition команда
	 * @param array  $params    параметры
	 *
	 * @return bool
	 */
	public static function execute($condition, $params = array())
	{
		return self::$_pdo->prepare($condition)->execute($params);
	}

	/**
	 * Выбирает одну запись
	 *
	 * @param string $condition команда
	 * @param array  $params    параметры
	 *
	 * @return array
	 */
	public static function fetch($condition, $params = array())
	{
		$sth = self::$_pdo->prepare($condition);
		$sth->execute($params);

		return $sth->fetch();
	}

	/**
	 * Выбирает несколько записей
	 *
	 * @param string $condition команда
	 * @param array  $params    параметры
	 *
	 * @return array
	 */
	public static function fetchAll($condition, $params = array())
	{
		$sth = self::$_pdo->prepare($condition);
		$sth->execute($params);

		return $sth->fetchAll();
	}

	/**
	 * Начинает трансакцию
	 *
	 * @return void
	 */
	public static function startTransaction()
	{
		self::$_pdo->beginTransaction();
	}

	/**
	 * Коммит трансакции
	 *
	 * @return void
	 */
	public static function commitTransaction()
	{
		self::$_pdo->commit();
	}

	/**
	 * Откат трансакции
	 *
	 * @return void
	 */
	public static function rollbackTransaction()
	{
		self::$_pdo->rollBack();
	}

	/**
	 * Вставляет запись в базу.
	 * В случае удачи возвращает идентификатор
	 *
	 * @param \system\base\Model $model
	 *
	 * @return int
	 */
	public static function insert($model)
	{
		$columns = array();
		$values = array();
		$substitutions = array();

		foreach ($model->rules() as $field => $value) {
			$columns[] = $field;
			$substitutions[] = "?";
			$values[] = $model->$field;
		}

		$query =
			"INSERT INTO " .
			$model->tableName() .
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
	 * Обновляет запись в базе.
	 *
	 * @param \system\base\Model $model
	 *
	 * @return bool
	 */
	public static function update($model)
	{
		$sets = array();
		$values = array();

		foreach ($model->rules() as $field => $value) {
			$sets[] = "$field = ?";
			$values[] = $model->$field;
		}

		$query = "UPDATE " . $model->tableName() . " SET " . implode(",", $sets) . " WHERE id = " . $model->id;

		return self::execute($query, $values);
	}

	/**
	 * Проверяет на существование таблицу
	 *
	 * @param string $table название таблицы
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