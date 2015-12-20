<?php

namespace system\db;

use system\base\Logger;

/**
 * Abstract class for working with migrations
 *
 * @package system.db
 */
abstract class Migration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	abstract public function up();

	/**
	 * Inserts test data
	 *
	 * @return bool
	 */
	abstract public function insertData();

	/**
	 * List of types
	 *
	 * @var array
	 */
	private $_columnTypes = [
		'pk'      => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'string'  => 'varchar(255) NOT NULL',
		'integer' => 'int(11) NOT NULL',
		'boolean' => 'tinyint(1) NOT NULL',
		'text'    => 'text NOT NULL',
	];

	/**
	 * Gets field type
	 *
	 * @param string $type Type
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
	 * Creates table
	 *
	 * @param string $table   Table name
	 * @param array  $columns Columns
	 * @param string $options Options
	 *
	 * @return bool
	 */
	public function createTable($table, $columns, $options = null)
	{
		$cols = [];
		foreach ($columns as $name => $type) {
			$cols[] = "`{$name}`" . ' ' . $this->getColumnType($type);
		}

		if (Db::execute("\nCREATE TABLE " . $table . " (\n" . implode(",\n", $cols) . "\n)" . $options)) {
			Logger::log("Таблица \"{$table}\" успешно создана", Logger::LEVEL_INFO, "console.migrations.table");
			return true;
		}

		Logger::log("Не удалось создать таблицу \"{$table}\"", Logger::LEVEL_INFO, "console.migrations.table");
		return false;
	}

	/**
	 * Creates index
	 *
	 * @param string $name   Index name
	 * @param string $table  Table name
	 * @param string $column Column
	 * @param bool   $unique Is unique index
	 *
	 * @return bool
	 */
	public function createIndex($name, $table, $column, $unique = false)
	{
		if (
			Db::execute(
				($unique ? 'CREATE UNIQUE INDEX ' : 'CREATE INDEX ')
				. $name . ' ON '
				. $table . ' (' . $column . ')'
			)
		) {
			Logger::log(
				"Индекс \"{$name}\" для таблицы \"{$table}\" успешно создан",
				Logger::LEVEL_INFO,
				"console.migrations.table"
			);
			return true;
		}

		Logger::log(
			"Не удалось создать индекс \"{$name}\" для таблицы \"{$table}\"",
			Logger::LEVEL_INFO,
			"console.migrations.index"
		);
		return false;
	}
}