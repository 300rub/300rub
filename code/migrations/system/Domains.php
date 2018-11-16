<?php

namespace ss\migrations\system;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing information about domains
 */
class Domains extends AbstractMigration
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
                'domains',
                [
                    'id'     => self::TYPE_PK,
                    'siteId' => self::TYPE_FK,
                    'name'   => self::TYPE_STRING,
                    'isMain' => self::TYPE_BOOL
                ]
            )
            ->createForeignKey(
                'domains',
                'siteId',
                'sites',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
    }
}
