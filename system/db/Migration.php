<?php

namespace system\db;
use system\base\Logger;

/**
 * Файл класса Migration
 *
 * @package system.db
 */
abstract class Migration
{

	/**
	 * Применяет миграцию
	 *
	 * @return bool
	 */
	abstract public function up();

	/**
	 * Добавляет тестовую информацию
	 *
	 * @return bool
	 */
	abstract public function insertData();

	/**
	 * Типы столбцов
	 *
	 * @var array
	 */
	private $_columnTypes = array(
		'pk'      => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'string'  => 'varchar(255) NOT NULL',
		'integer' => 'int(11) NOT NULL',
		'boolean' => 'tinyint(1) NOT NULL',
		'text'    => 'text NOT NULL',
	);

	/**
	 * Создает таблицу
	 *
	 * @param string $table   таблица
	 * @param array  $columns столбцы
	 * @param string $options опции
	 *
	 * @return bool
	 */
	public function createTable($table, $columns, $options = null)
	{
		$cols = array();
		foreach ($columns as $name => $type) {
			$cols[] = "`{$name}`" . ' ' . $this->getColumnType($type);
		}
		$query = "\nCREATE TABLE " . $table . " (\n" . implode(",\n", $cols) . "\n)" . $options;
		$result = $this->execute($query);
		if ($result) {
			Logger::log("Table \"{$table}\" successfully created", Logger::LEVEL_INFO, "console.migrations.table");
			return true;
		}

		Logger::log("Table \"{$table}\" could not be created", Logger::LEVEL_INFO, "console.migrations.table");
		return false;
	}

	/**
	 * Добавляет внешний ключ
	 *
	 * @param string $name      название
	 * @param string $table     таблица
	 * @param string $column    столбец
	 * @param string $refTable  связная таблица
	 * @param string $refColumn связной столбец
	 * @param string $delete    on delete
	 * @param string $update    on update
	 *
	 * @return void
	 */
	public function addForeignKey($name, $table, $column, $refTable, $refColumn, $delete = null, $update = null)
	{
		$query = 'ALTER TABLE ' . $table
			. ' ADD CONSTRAINT ' . $name
			. ' FOREIGN KEY (' . $column . ')'
			. ' REFERENCES ' . $refTable
			. ' (' . $refColumn . ')';
		if ($delete !== null) {
			$query .= ' ON DELETE ' . $delete;
		}
		if ($update !== null) {
			$query .= ' ON UPDATE ' . $update;
		}
		$this->execute($query);
	}

	/**
	 * Создает индекс
	 *
	 * @param string $name   название
	 * @param string $table  таблица
	 * @param string $column столбец
	 * @param bool   $unique уникальный ли индекс
	 *
	 * @return bool
	 */
	public function createIndex($name, $table, $column, $unique = false)
	{
		$query = ($unique ? 'CREATE UNIQUE INDEX ' : 'CREATE INDEX ')
			. $name . ' ON '
			. $table . ' (' . $column . ')';
		$result = $this->execute($query);

		if ($result) {
			Logger::log(
				"Index \"{$name}\" for table \"{$table}\" successfully created",
				Logger::LEVEL_INFO,
				"console.migrations.table"
			);
			return true;
		}

		Logger::log(
			"Index \"{$name}\" for table \"{$table}\" could not be created",
			Logger::LEVEL_INFO,
			"console.migrations.table"
		);
		return false;
	}

	/**
	 * Получает тип столбца
	 *
	 * @param string $type тип
	 *
	 * @return string
	 */
	public function getColumnType($type)
	{
		if (array_key_exists($type, $this->_columnTypes)) {
			return $this->_columnTypes[$type];
		}

		return $type;
	}

	/**
	 * Выполняет запрос
	 *
	 * @param string $query запрос
	 *
	 * @return bool
	 */
	public function execute($query)
	{
		return mysql_query($query);
	}
}