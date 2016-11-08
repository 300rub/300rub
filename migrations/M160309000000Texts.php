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
                    "designTextId"  => self::TYPE_FK,
                    "designBlockId" => self::TYPE_FK,
                    "name"          => self::TYPE_STRING,
                    "language"      => self::TYPE_TINYINT_UNSIGNED,
                    "type"          => self::TYPE_TINYINT_UNSIGNED,
                    "isEditor"      => self::TYPE_BOOL,
                    "text"          => self::TYPE_TEXT,
                ]
            )
            ->createForeignKey("texts", "designTextId", "designTexts")
            ->createForeignKey("texts", "designBlockId", "designBlocks");
    }
}