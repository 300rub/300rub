<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates files table
 */
class M190101000700Files extends AbstractMigration
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
                ]
            )
            ->createUniqueIndex('files', 'files_uniqueName', 'uniqueName')
            ->createIndex('files', 'date');
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
