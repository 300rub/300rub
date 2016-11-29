<?php

namespace testS\migrations;

/**
 * Creates records tables
 *
 * @package testS\migrations
 */
class M160321000200Menu extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designMenu",
                [
                    "id"                       => self::TYPE_PK,
                    "designBlockId"            => self::TYPE_FK,
                    "firstLevelDesignBlockId"  => self::TYPE_FK,
                    "firstLevelDesignTextId"   => self::TYPE_FK,
                    "secondLevelDesignBlockId" => self::TYPE_FK_NULL,
                    "secondLevelDesignTextId"  => self::TYPE_FK_NULL,
                    "lastLevelDesignBlockId"   => self::TYPE_FK_NULL,
                    "lastLevelDesignTextId"    => self::TYPE_FK_NULL,
                ]
            )
            ->createForeignKey("designMenu", "designBlockId", "designBlocks")
            ->createForeignKey("designMenu", "firstLevelDesignBlockId", "designBlocks")
            ->createForeignKey("designMenu", "firstLevelDesignTextId", "designTexts")
            ->createForeignKey(
                "designMenu",
                "secondLevelDesignBlockId",
                "designBlocks",
                self::FK_CASCADE,
                self::FK_NULL
            )
            ->createForeignKey("designMenu", "secondLevelDesignTextId", "designTexts", self::FK_CASCADE, self::FK_NULL)
            ->createForeignKey("designMenu", "lastLevelDesignBlockId", "designBlocks", self::FK_CASCADE, self::FK_NULL)
            ->createForeignKey("designMenu", "lastLevelDesignTextId", "designTexts", self::FK_CASCADE, self::FK_NULL)
            ->createTable(
                "menu",
                [
                    "id"           => self::TYPE_PK,
                    "designMenuId" => self::TYPE_FK,
                    "type"         => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("menu", "designMenuId", "designMenu")
            ->createTable(
                "menuInstances",
                [
                    "id"        => self::TYPE_PK,
                    "menuId"    => self::TYPE_FK,
                    "parentId"  => self::TYPE_FK,
                    "sectionId" => self::TYPE_FK,
                    "icon"      => self::TYPE_STRING_50,
                    "subName"   => self::TYPE_STRING
                ]
            )
            ->createForeignKey("menuInstances", "menuId", "menu")
            ->createForeignKey("menuInstances", "parentId", "menuInstances")
            ->createForeignKey("menuInstances", "sectionId", "sections");
    }
}