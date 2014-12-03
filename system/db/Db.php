<?php

namespace system\db;

use system\App;
use system\base\Logger;
use system\base\Model;
use system\base\Exception;
use system\base\Language;

/**
 * Файл класса Db
 *
 * @package system.db
 */
class Db
{

	const PREFIX = "s_";

	/**
	 * Установлено ли соединение
	 *
	 * @var bool
	 */
	private static $_isConnect = false;

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
	 * Связи
	 *
	 * @var array
	 */
	public $relations = array();

	/**
	 * Устанавливает соединение с базой
	 *
	 * @param string $user            пользователь
	 * @param string $password        пароль
	 * @param string $base            база
	 * @param bool   $isNewConnection новое соединение
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	public static function setConnect($user, $password, $base, $isNewConnection = false)
	{
		if (self::$_isConnect && !$isNewConnection) {
			return true;
		}

		if (!mysql_connect("localhost", $user, $password)) {
			Logger::log(Language::t("db", "Could not connect to MySQL server"), Logger::LEVEL_ERROR, "db");
			return false;
		}

		if (!mysql_select_db($base)) {
			Logger::log(Language::t("db", "Unable to select database"), Logger::LEVEL_ERROR, "db");
			return false;
		}

		if (!mysql_query("SET NAMES 'utf8'") || !mysql_set_charset("utf8")) {
			Logger::log(Language::t("db", "Failed to set the encoding for the database"), Logger::LEVEL_ERROR, "db");
			return false;
		}

		self::$_isConnect = true;

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

		if ($this->condition && $this->params) {
			foreach ($this->params as $key => $val) {
				$val = mysql_escape_string(htmlspecialchars(strip_tags(trim($val))));
				$this->condition = str_replace(
					":{$key}",
					"'{$val}'",
					$this->condition
				);
			}
		}

		foreach ($join as $item) {
			$query .= $item;
		}

		if ($this->condition) {
			$query .= " WHERE {$this->condition}";
		}

		if ($this->limit) {
			$query .= " LIMIT {$this->limit}";
		}

		if (App::$isDebug) {
			echo "<script>console.log(\"{$query}\");</script>";
		}

		return $query;
	}

	/**
	 * Получает ассоциативный массив с данными из БД
	 *
	 * @return array
	 */
	public function getResult()
	{
		$rows = array();

		$result = mysql_query($this->_getQuery());
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				$rows[] = $row;
			}
		}

		return $rows;
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
	 * @param string $table название таблицы
	 *
	 * @return bool
	 */
	public static function isTableExist($table)
	{
		return (bool)mysql_query("SELECT * FROM `" . $table . "` WHERE 0");
	}

	public static function startTransaction()
	{
		mysql_query("START TRANSACTION");
	}

	public static function commitTransaction()
	{
		mysql_query("COMMIT");
	}

	public static function rollbackTransaction()
	{
		mysql_query("ROLLBACK");
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

		foreach ($model->rules() as $field => $value) {
			$columns[] = $field;
			$values[] = "'" . mysql_real_escape_string($model->$field) . "'";
		}

		$query =
			"INSERT INTO " .
			$model->tableName() .
			" (" .
			implode(",", $columns) .
			") VALUES (" .
			implode(",", $values) .
			")";
		if (!mysql_query($query)) {
			return 0;
		}

		$result = mysql_query("SELECT LAST_INSERT_ID() FROM " . $model->tableName());
		if (!$result) {
			return 0;
		}

		$row = mysql_fetch_assoc($result);
		if (!$row || empty($row["LAST_INSERT_ID()"])) {
			return 0;
		}

		return $row["LAST_INSERT_ID()"];
	}
}