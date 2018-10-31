<?php

namespace ss\migrations\_abstract;

use ss\application\App;
use ss\application\exceptions\MigrationException;

/**
 * Abstract class for working with migrations
 *
 * @codingStandardsIgnoreStart
 * @SuppressWarnings(PMD.NumberOfChildren)
 * @codingStandardsIgnoreEnd
 */
abstract class AbstractMigration
{

    /**
     * Default options for table
     */
    const TABLE_DEFAULT_OPTIONS
        = 'ENGINE=InnoDB AUTO_INCREMENT=1' .
        ' DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';

    /**
     * Foreign key ON events
     */
    const FK_RESTRICT = 'RESTRICT';
    const FK_CASCADE = 'CASCADE';
    const FK_NULL = 'SET NULL';

    /**
     * Column types
     */
    const TYPE_PK = 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL';
    const TYPE_FK = 'INT(11) UNSIGNED NOT NULL';
    const TYPE_FK_NULL = 'INT(11) UNSIGNED NULL';
    const TYPE_STRING = 'VARCHAR(255) NOT NULL';
    const TYPE_STRING_100 = 'VARCHAR(100) NOT NULL';
    const TYPE_STRING_50 = 'VARCHAR(50) NOT NULL';
    const TYPE_STRING_25 = 'VARCHAR(25) NOT NULL';
    const TYPE_CHAR_32 = 'CHAR(32) NOT NULL';
    const TYPE_CHAR_40 = 'CHAR(40) NOT NULL';
    const TYPE_INT = 'INT NOT NULL';
    const TYPE_INT_UNSIGNED = 'INT UNSIGNED NOT NULL';
    const TYPE_TINYINT = 'TINYINT NOT NULL';
    const TYPE_TINYINT_UNSIGNED = 'TINYINT(3) UNSIGNED NOT NULL';
    const TYPE_SMALLINT = 'SMALLINT NOT NULL';
    const TYPE_SMALLINT_UNSIGNED = 'SMALLINT UNSIGNED NOT NULL';
    const TYPE_BOOL = 'TINYINT(1) UNSIGNED NOT NULL';
    const TYPE_TEXT = 'TEXT NOT NULL';
    const TYPE_DATETIME = 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP';
    const TYPE_FLOAT = 'FLOAT NOT NULL';

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = false;

    /**
     * Applies migration
     *
     * @return bool
     */
    abstract public function apply();

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
    public function createTable(
        $table,
        $columns,
        $options = self::TABLE_DEFAULT_OPTIONS
    ) {
        $cols = [];
        foreach ($columns as $name => $type) {
            $cols[] = sprintf('`%s` %s', $name, $type);
        }

        App::getInstance()
            ->getDb()
            ->execute(
                "\nCREATE TABLE " .
                $table .
                " (\n" .
                implode(",\n", $cols) .
                "\n)" .
                $options
            );

        return $this;
    }

    /**
     * Creates index
     *
     * @param string $table  Table name
     * @param string $column Column
     * @param string $index  Index
     *
     * @throws MigrationException
     *
     * @return AbstractMigration
     */
    public function createIndex($table, $column, $index = null)
    {
        if ($index === null) {
            $index = sprintf('%s_%s', $table, $column);
        }

        App::getInstance()->getDb()->execute(
            sprintf(
                'ALTER' . ' TABLE %s ADD INDEX %s (%s)',
                $table,
                $index,
                $column
            )
        );

        return $this;
    }

    /**
     * Creates FULLTEXT index
     *
     * @param string $table  Table name
     * @param string $column Column
     *
     * @throws MigrationException
     *
     * @return AbstractMigration
     */
    public function createFullTextIndex($table, $column)
    {
        App::getInstance()->getDb()->execute(
            sprintf(
                'ALTER' . ' TABLE %s ADD FULLTEXT(%s)',
                $table,
                $column
            )
        );

        return $this;
    }

    /**
     * Creates unique index
     *
     * @param string $table   Table name
     * @param string $name    Name
     * @param string $columns Columns
     *
     * @throws MigrationException
     *
     * @return AbstractMigration
     */
    public function createUniqueIndex($table, $name, $columns)
    {
        App::getInstance()->getDb()->execute(
            sprintf(
                'ALTER' . ' TABLE %s ADD UNIQUE INDEX %s (%s)',
                $table,
                $name,
                $columns
            )
        );

        return $this;
    }

    /**
     * Creates Foreign key
     *
     * @param string $table     Table
     * @param string $column    Column
     * @param string $reference Reference
     * @param string $onUpdate  On update
     * @param string $onDelete  On delete
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
    ) {
        App::getInstance()->getDb()->execute(
            sprintf(
                'ALTER' . ' TABLE %s ADD CONSTRAINT ' .
                '%s_%s_fk FOREIGN KEY (%s) ' .
                'REFERENCES %s(id) ON UPDATE %s ON DELETE %s',
                $table,
                $table,
                $column,
                $column,
                $reference,
                $onUpdate,
                $onDelete
            )
        );

        return $this;
    }
}
