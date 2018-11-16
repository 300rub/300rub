<?php

namespace ss\migrations\system;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing list of migrations
 */
class Migrations extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    protected function up()
    {
        $this->createTable(
            'migrations',
            [
                'id'      => self::TYPE_PK,
                'version' => self::TYPE_STRING_100,
                'down'    => self::TYPE_TEXT,
            ]
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
