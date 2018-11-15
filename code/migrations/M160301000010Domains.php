<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing information about domains
 */
class M160301000010Domains extends AbstractMigration
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
