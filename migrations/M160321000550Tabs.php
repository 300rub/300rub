<?php

namespace testS\migrations;

/**
 * Creates tab tables
 *
 * @package testS\migrations
 */
class M160321000550Tabs extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designTabs",
                [
                    "id"                     => self::TYPE_PK,
                    "containerDesignBlockId" => self::TYPE_FK,
                    "tabDesignBlockId"       => self::TYPE_FK,
                    "tabDesignTextId"        => self::TYPE_FK,
                    "contentDesignBlockId"   => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designTabs", "containerDesignBlockId", "designBlocks")
            ->createForeignKey("designTabs", "tabDesignBlockId", "designBlocks")
            ->createForeignKey("designTabs", "tabDesignTextId", "designTexts")
            ->createForeignKey("designTabs", "contentDesignBlockId", "designBlocks")
            ->createTable(
                "tabs",
                [
                    "id"           => self::TYPE_PK,
                    "designTabsId" => self::TYPE_FK,
                    "textId"       => self::TYPE_FK,
                    "isShowEmpty"  => self::TYPE_BOOL,
                    "isLazyLoad"   => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("tabs", "designTabsId", "designTabs")
            ->createForeignKey("tabs", "textId", "texts")
            ->createTable(
                "tabTemplates",
                [
                    "id"    => self::TYPE_PK,
                    "tabId" => self::TYPE_FK,
                    "sort"  => self::TYPE_SMALLINT,
                    "label" => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("tabTemplates", "tabId", "tabs", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("tabTemplates", "sort")
            ->createTable(
                "tabGroups",
                [
                    "id"    => self::TYPE_PK,
                    "tabId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("tabGroups", "tabId", "tabs")
            ->createTable(
                "tabInstances",
                [
                    "id"             => self::TYPE_PK,
                    "tabGroupId"     => self::TYPE_FK,
                    "textInstanceId" => self::TYPE_FK,
                    "tabTemplateId"  => self::TYPE_FK,
                ]
            )
            ->createForeignKey("tabInstances", "tabGroupId", "tabGroups", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("tabInstances", "textInstanceId", "textInstances")
            ->createForeignKey("tabInstances", "tabTemplateId", "tabTemplates", self::FK_CASCADE, self::FK_CASCADE);
    }
}