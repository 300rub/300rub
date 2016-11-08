<?php

namespace testS\migrations;

/**
 * Creates sections table
 *
 * @package testS\migrations
 */
class M160305000000Sections extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "sections",
                [
                    "id"            => self::TYPE_PK,
                    "seoId"         => self::TYPE_INT,
                    "designBlockId" => self::TYPE_INT,
                    "language"      => self::TYPE_TINYINT,
                    "width"         => self::TYPE_SMALLINT,
                    "isMain"        => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("sections", "seoId", "seo")
            ->createIndex("sections", "language")
            ->createIndex("sections", "isMain")
            ->createIndex("sections", "designBlockId");
    }
}