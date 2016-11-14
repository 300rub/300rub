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
     * Column types
     */
    const TYPE_PK = "INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL";
    const TYPE_FK = "INT(11) UNSIGNED NOT NULL";
    const TYPE_FK_NULL = "INT(11) UNSIGNED NULL";
    const TYPE_STRING = 'VARCHAR(255) NOT NULL';
    const TYPE_STRING_100 = 'VARCHAR(100) NOT NULL';
    const TYPE_STRING_50 = 'VARCHAR(50) NOT NULL';
    const TYPE_STRING_25 = 'VARCHAR(25) NOT NULL';
    const TYPE_CHAR_40 = 'CHAR(40) NOT NULL';
    const TYPE_INT = 'INT NOT NULL';
    const TYPE_INT_UNSIGNED = 'INT UNSIGNED NOT NULL';
    const TYPE_TINYINT = 'TINYINT NOT NULL';
    const TYPE_TINYINT_UNSIGNED = 'TINYINT UNSIGNED NOT NULL';
    const TYPE_SMALLINT = 'SMALLINT NOT NULL';
    const TYPE_SMALLINT_UNSIGNED = 'SMALLINT UNSIGNED NOT NULL';
    const TYPE_BOOL = 'TINYINT(1) UNSIGNED NOT NULL';
    const TYPE_TEXT = 'TEXT NOT NULL';

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
            $cols[] = "`{$name}`" . ' ' . $type;
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
                sprintf(
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
                    "ALTER" . " TABLE %s ADD CONSTRAINT %s_%s_fk FOREIGN KEY (%s) " .
                    "REFERENCES %s(id) ON UPDATE %s ON DELETE %s",
                    $table,
                    $table,
                    $column,
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