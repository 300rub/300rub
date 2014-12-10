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

		if (Db::execute("\nCREATE TABLE " . $table . " (\n" . implode(",\n", $cols) . "\n)" . $options)) {
			Logger::log("Таблица \"{$table}\" успешно создана", Logger::LEVEL_INFO, "console.migrations.table");
			return true;
		}

		Logger::log("Не удалось создать таблицу \"{$table}\"", Logger::LEVEL_INFO, "console.migrations.table");
		return false;
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