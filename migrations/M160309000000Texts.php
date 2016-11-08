<?php

namespace testS\migrations;

/**
 * Creates texts table
 *
 * @package testS\migrations
 */
class M160309000000Texts extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "texts",
                [
                    "id"            => self::TYPE_PK,
                    "designTextId"  => self::TYPE_INT,
                    "designBlockId" => self::TYPE_INT,
                    "name"          => self::TYPE_STRING,
                    "language"      => self::TYPE_TINYINT,
                    "type"          => self::TYPE_TINYINT,
                    "isEditor"      => self::TYPE_BOOL,
                    "text"          => self::TYPE_TEXT,
                ]
            )
            ->createForeignKey("texts", "designTextId", "designTexts")
            ->createForeignKey("texts", "designBlockId", "designBlocks");
    }
}