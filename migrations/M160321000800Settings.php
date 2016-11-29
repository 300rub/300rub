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
                    "id"          => self::TYPE_PK,
                    "iconImageId" => self::TYPE_FK,
                    "seoId"       => self::TYPE_FK,
                ]
            )
            ->createForeignKey("settings", "iconImageId", "images")
            ->createForeignKey("settings", "seoId", "seo");
    }
}