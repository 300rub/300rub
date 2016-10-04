<?php

namespace migrations;

use testS\components\Db;
use testS\components\exceptions\MigrationException;

/**
 * Abstract class for working with migrations
 *
 * @package migrations
 */
abstract class AbstractMigration
{

	/**
	 * Default options for table
	 */
	const TABLE_DEFAULT_OPTIONS = "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

	/**
	 * Flag. If it is true - it will be skipped in common applying
	 *
	 * @var bool
	 */
	public $isSkip = false;

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	abstract public function up();

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
	 * @throws MigrationException
	 *
	 * @return AbstractMigration
	 */
	public function createTable($table, $columns, $options = self::TABLE_DEFAULT_OPTIONS)
	{
		$cols = [];
		foreach ($columns as $name => $type) {
			$cols[] = "`{$name}`" . ' ' . $this->getColumnType($type);
		}

		if (!Db::execute("\nCREATE TABLE " . $table . " (\n" . implode(",\n", $cols) . "\n)" . $options)) {
			throw new MigrationException("Unable to create the table {table}", ["table" => $table]);
		}

		return $this;
	}

	/**
	 * Creates index
	 *
	 * @param string $name   Index name
	 * @param string $table  Table name
	 * @param string $column Column
	 * @param bool   $unique Is unique index
	 *
	 * @throws MigrationException
	 *
	 * @return AbstractMigration
	 */
	public function createIndex($name, $table, $column, $unique = false)
	{
		if (
			!Db::execute(
				($unique ? "CREATE" . " UNIQUE INDEX " : "CREATE" . " INDEX ")
				. $name . ' ON '
				. $table . ' (' . $column . ')'
			)
		) {
			throw new MigrationException(
				"Unable to create the index {index} for table {table}",
				[
					"index" => $name,
					"table" => $table
				]
			);
		}

		return $this;
	}
}