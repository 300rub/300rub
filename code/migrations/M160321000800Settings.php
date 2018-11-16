<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates settings table
 */
class M160321000800Settings extends AbstractMigration
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
                'settings',
                [
                    'id'    => self::TYPE_PK,
                    'type'  => self::TYPE_STRING_25,
                    'value' => self::TYPE_TEXT,
                ]
            )
            ->createUniqueIndex('settings', 'settings_type', 'type');
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('settings');
    }
}
