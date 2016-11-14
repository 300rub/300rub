<?php

namespace testS\migrations;

/**
 * Creates blocks table
 *
 * @package testS\migrations
 */
class M160302000005Blocks extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "blocks",
                [
                    "id"          => self::TYPE_PK,
                    "name"        => self::TYPE_STRING,
                    "language"    => self::TYPE_TINYINT_UNSIGNED,
                    "contentType" => self::TYPE_TINYINT_UNSIGNED,
                    "contentId"   => self::TYPE_FK
                ]
            )
            ->createIndex("blocks", "language")
            ->createIndex("blocks", "contentType")
            ->createIndex("blocks", "contentId");
    }
}