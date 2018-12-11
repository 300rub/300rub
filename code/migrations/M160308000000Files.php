<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates files table
 */
class M160308000000Files extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    protected function up()
    {
        $this
            ->createTable(
                'files',
                [
                    'id'           => self::TYPE_PK,
                    'originalName' => self::TYPE_STRING,
                    'type'         => self::TYPE_STRING_50,
                    'size'         => self::TYPE_INT_UNSIGNED,
                    'uniqueName'   => self::TYPE_STRING_25,
                    'date'         => self::TYPE_DATETIME,
                    'isUsed'       => self::TYPE_BOOL,
                ]
            )
            ->createUniqueIndex('files', 'files_uniqueName', 'uniqueName')
            ->createIndex(
                'files',
                'date, isUsed',
                'files_date_isUsed'
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('files');
    }
}
