<?php

namespace system\db;

use system\App;
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
	 * @param string $host            хост
	 * @param string $user            пользователь
	 * @param string $password        пароль
	 * @param string $base            база
	 * @param string $charset         кодировка
	 * @param bool   $isNewConnection новое соединение
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	public static function setConnect($host, $user, $password, $base, $charset, $isNewConnection = false)
	{
		if (self::$_isConnect && !$isNewConnection) {
			return true;
		}

		if (!mysql_connect($host, $user, $password)) {
			throw new Exception(Language::t("db", "Could not connect to MySQL server"));
		}

		if (!mysql_select_db($base)) {
			throw new Exception(Language::t("db", "Unable to select database"));
		}

		if (!mysql_query("SET NAMES '{$charset}'") || !mysql_set_charset($charset)) {
			throw new Exception(Language::t("db", "Failed to set the encoding for the database"));
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
}