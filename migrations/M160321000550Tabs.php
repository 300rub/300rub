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
                    "id"                   => self::TYPE_PK,
                    "designBlockId"        => self::TYPE_FK,
                    "tabDesignBlockId"     => self::TYPE_FK,
                    "tabDesignTextId"      => self::TYPE_FK,
                    "contentDesignBlockId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designTabs", "designBlockId", "designBlocks")
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
                "tabGroups",
                [
                    "id" => self::TYPE_PK,
                ]
            )
            ->createTable(
                "tabInstances",
                [
                    "id"    => self::TYPE_PK,
                    "tabId" => self::TYPE_FK,
                    "sort"  => self::TYPE_SMALLINT,
                    "label" => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("tabInstances", "tabId", "tabs")
            ->createIndex("tabInstances", "sort")
            ->createTable(
                "tabValues",
                [
                    "id"             => self::TYPE_PK,
                    "tabGroupId"     => self::TYPE_FK,
                    "tabInstanceId"  => self::TYPE_FK,
                    "textInstanceId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("tabValues", "tabGroupId", "tabGroups")
            ->createForeignKey("tabValues", "tabInstanceId", "tabInstances")
            ->createForeignKey("tabValues", "textInstanceId", "textInstances");
    }
}