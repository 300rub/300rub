<?php

namespace testS\migrations;

/**
 * Creates records tables
 *
 * @package testS\migrations
 */
class M160321000300SiteMaps extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "siteMaps",
                [
                    "id"                     => self::TYPE_PK,
                    "containerDesignBlockId" => self::TYPE_FK,
                    "itemDesignBlockId"      => self::TYPE_FK,
                    "itemDesignTextId"       => self::TYPE_FK,
                    "style"                  => self::TYPE_TINYINT_UNSIGNED
                ]
            )
            ->createForeignKey("siteMaps", "containerDesignBlockId", "designBlocks")
            ->createForeignKey("siteMaps", "itemDesignBlockId", "designBlocks")
            ->createForeignKey("siteMaps", "itemDesignTextId", "designTexts");
    }
}