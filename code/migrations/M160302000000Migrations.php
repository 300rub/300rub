<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing list of migrations
 */
class M160302000000Migrations extends AbstractMigration
{

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = true;

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
                'up'      => self::TYPE_TEXT,
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
