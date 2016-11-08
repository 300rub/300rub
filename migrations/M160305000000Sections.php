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
                    "seoId"         => self::TYPE_FK,
                    "designBlockId" => self::TYPE_FK,
                    "language"      => self::TYPE_TINYINT_UNSIGNED,
                    "width"         => self::TYPE_SMALLINT_UNSIGNED,
                    "isMain"        => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("sections", "seoId", "seo")
            ->createIndex("sections", "language")
            ->createIndex("sections", "isMain")
            ->createIndex("sections", "designBlockId");
    }
}