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
                    "id"            => "pk",
                    "seoId"         => "integer",
                    "language"      => "integer",
                    "width"         => "integer",
                    "isMain"        => "boolean",
                    "designBlockId" => "integer"
                ]
            )
            ->createForeignKey("sections", "seoId", "seo")
            ->createIndex("sections", "language")
            ->createIndex("sections", "isMain")
            ->createIndex("sections", "designBlockId");
    }
}