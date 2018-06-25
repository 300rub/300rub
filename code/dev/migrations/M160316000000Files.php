<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates files table
 */
class M160316000000Files extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
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
                ]
            )
            ->createUniqueIndex('files', 'files_uniqueName', 'uniqueName');
    }
}
