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
    const TYPE_STRING = 'VARCHAR(255) NOT NULL DEFAULT ""';
    const TYPE_STRING_100 = 'VARCHAR(100) NOT NULL DEFAULT ""';
    const TYPE_STRING_50 = 'VARCHAR(50) NOT NULL DEFAULT ""';
    const TYPE_STRING_25 = 'VARCHAR(25) NOT NULL DEFAULT ""';
    const TYPE_CHAR_32 = 'CHAR(32) NOT NULL DEFAULT ""';
    const TYPE_CHAR_40 = 'CHAR(40) NOT NULL DEFAULT ""';
    const TYPE_INT = 'INT NOT NULL DEFAULT 0';
    const TYPE_INT_UNSIGNED = 'INT UNSIGNED NOT NULL DEFAULT 0';
    const TYPE_TINYINT = 'TINYINT NOT NULL DEFAULT 0';
    const TYPE_TINYINT_UNSIGNED = 'TINYINT(3) UNSIGNED NOT NULL DEFAULT 0';
    const TYPE_SMALLINT = 'SMALLINT NOT NULL DEFAULT 0';
    const TYPE_SMALLINT_UNSIGNED = 'SMALLINT UNSIGNED NOT NULL DEFAULT 0';
    const TYPE_BOOL = 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0';
    const TYPE_TEXT = 'TEXT NOT NULL';
    const TYPE_DATETIME = 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP';
    const TYPE_FLOAT = 'FLOAT NOT NULL DEFAULT 0';

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = false;

    /**
     * SQL
     *
     * @var string[]
     */
    private $_sql = [];

    /**
     * SQL up
     *
     * @return void
     */
    abstract protected function up();

    /**
     * SQL down
     *
     * @return void
     */
    abstract protected function down();

    /**
     * Adds SQL
     *
     * @param string $sql SQL
     *
     * @return AbstractMigration
     */
    private function _addSql($sql)
    {
        $this->_sql[] = $sql;

        return $this;
    }

    /**
     * Gets SQL as string
     *
     * @return string
     */
    private function _getSqlString()
    {
        return implode(' ', $this->_sql);
    }

    /**
     * Executes SQL
     *
     * @param string $sql SQL
     *
     * @return AbstractMigration
     */
    public function execute($sql)
    {
        App::getInstance()->getDb()->execute($sql);
        return $this;
    }

    /**
     * Generates SQL up
     *
     * @return string
     */
    public function generateSqlUp()
    {
        $this->_sql = [];

        $this->up();

        return $this->_getSqlString();
    }

    /**
     * Generates SQL down
     *
     * @return string
     */
    public function generateSqlDown()
    {
        $this->_sql = [];

        $this->down();

        return $this->_getSqlString();
    }

    /**
     * Creates table
     *
     * @param string $table   Table name
     * @param array  $columns Columns
     * @param string $options Options
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

        $this->_addSql(
            sprintf(
                'CREATE TABLE IF NOT EXISTS %s (%s) %s;',
                $table,
                implode(', ', $cols),
                $options
            )
        );

        return $this;
    }

    /**
     * Drops table
     *
     * @param string $table Table name
     *
     * @return AbstractMigration
     */
    public function dropTable($table)
    {
        $this->_addSql(
            sprintf(
                'DROP TABLE IF EXISTS %s;',
                $table
            )
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
     * @return AbstractMigration
     */
    public function createIndex($table, $column, $index = null)
    {
        if ($index === null) {
            $index = sprintf('%s_%s', $table, $column);
        }

        $this->_addSql(
            sprintf(
                'ALTER TABLE %s ADD INDEX %s (%s);',
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
     * @return AbstractMigration
     */
    public function createFullTextIndex($table, $column)
    {
        $this->_addSql(
            sprintf(
                'ALTER TABLE %s ADD FULLTEXT(%s);',
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
     * @return AbstractMigration
     */
    public function createUniqueIndex($table, $name, $columns)
    {
        $this->_addSql(
            sprintf(
                'ALTER TABLE %s ADD UNIQUE INDEX %s (%s);',
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
     */
    public function createForeignKey(
        $table,
        $column,
        $reference,
        $onUpdate = self::FK_RESTRICT,
        $onDelete = self::FK_RESTRICT
    ) {
        $this->_addSql(
            sprintf(
                'ALTER TABLE %s ADD CONSTRAINT ' .
                '%s_%s_fk FOREIGN KEY (%s) ' .
                'REFERENCES %s(id) ON UPDATE %s ON DELETE %s;',
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
