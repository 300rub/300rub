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
                    "type"          => self::TYPE_TINYINT_UNSIGNED,
                    "hasEditor"     => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("texts", "designTextId", "designTexts")
            ->createForeignKey("texts", "designBlockId", "designBlocks")
            ->createTable(
                "textInstances",
                [
                    "id"     => self::TYPE_PK,
                    "textId" => self::TYPE_FK,
                    "text"   => self::TYPE_TEXT,
                ]
            )
            ->createForeignKey("textInstances", "textId", "texts", self::FK_CASCADE, self::FK_CASCADE)
            ->createFullTextIndex("textInstances", "text");
    }
}