<?php

namespace testS\migrations;

use testS\components\Db;
use testS\components\exceptions\MigrationException;
use Exception;

/**
 * Abstract class for working with migrations
 *
 * @package testS\migrations
 */
abstract class AbstractMigration
{

    /**
     * Default options for table
     */
    const TABLE_DEFAULT_OPTIONS = "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

    /**
     * Foreign key ON events
     */
    const FK_RESTRICT = "RESTRICT";
    const FK_CASCADE = "CASCADE";

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
     * @param string $table  Table name
     * @param string $column Column
     *
     * @throws MigrationException
     *
     * @return AbstractMigration
     */
    public function createIndex($table, $column)
    {
        try {
            Db::execute(
                printf(
                    "ALTER" . " TABLE %s ADD INDEX %s_%s (%s)",
                    $table,
                    $table,
                    $column,
                    $column
                )
            );
        } catch (Exception $e) {
            throw new MigrationException(
                "Exception: {e}. Unable to create index for column {column} for table {table}",
                [
                    "e"      => $e->getMessage(),
                    "column" => $column,
                    "table"  => $table
                ]
            );
        }

        return $this;
    }

    /**
     * Creates Foreign key
     *
     * @param string $table
     * @param string $column
     * @param string $reference
     * @param string $onUpdate
     * @param string $onDelete
     *
     * @return AbstractMigration
     *
     * @throws MigrationException
     */
    public function createForeignKey(
        $table,
        $column,
        $reference,
        $onUpdate = self::FK_RESTRICT,
        $onDelete = self::FK_RESTRICT
    )
    {
        try {
            Db::execute(
                sprintf(
                    "ALTER" . " TABLE %s ADD FOREIGN KEY (%s_%s_fk) REFERENCES %s(id) ON UPDATE %s ON DELETE %s",
                    $table,
                    $table,
                    $column,
                    $reference,
                    $onUpdate,
                    $onDelete
                )
            );
        } catch (Exception $e) {
            throw new MigrationException(
                "Exception: {e}. Unable to create foreign key for column {column} for table {table}",
                [
                    "e"      => $e->getMessage(),
                    "column" => $column,
                    "table"  => $table
                ]
            );
        }

        return $this;
    }
}