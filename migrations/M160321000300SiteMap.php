<?php

namespace testS\migrations;

/**
 * Creates records tables
 *
 * @package testS\migrations
 */
class M160321000300SiteMap extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "siteMap",
                [
                    "id"                => self::TYPE_PK,
                    "designBlockId"     => self::TYPE_FK,
                    "itemDesignBlockId" => self::TYPE_FK,
                    "itemDesignTextId"  => self::TYPE_FK,
                    "style"             => self::TYPE_TINYINT_UNSIGNED
                ]
            )
            ->createForeignKey("siteMap", "designBlockId", "designBlocks")
            ->createForeignKey("siteMap", "itemDesignBlockId", "designBlocks")
            ->createForeignKey("siteMap", "itemDesignTextId", "designTexts");
    }
}