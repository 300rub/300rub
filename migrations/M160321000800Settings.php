<?php

namespace testS\migrations;

/**
 * Creates settings table
 *
 * @package testS\migrations
 */
class M160321000800Settings extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "settings",
                [
                    "id"    => self::TYPE_PK,
                    "type"  => self::TYPE_STRING_25,
                    "value" => self::TYPE_STRING,
                ]
            )
            ->createUniqueIndex("settings", "settings_type", "type");
    }
}