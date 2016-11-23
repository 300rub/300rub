<?php

namespace testS\migrations;

/**
 * Creates catalog tables
 *
 * @package testS\migrations
 */
class M160321000700Catalog extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designFields",
                [
                    "id"                          => self::TYPE_PK,
                    "shortCardDesignBlockId"      => self::TYPE_FK,
                    "shortCardLabelDesignBlockId" => self::TYPE_FK,
                    "shortCardLabelDesignTextId"  => self::TYPE_FK,
                    "shortCardValueDesignBlockId" => self::TYPE_FK,
                    "shortCardValueDesignTextId"  => self::TYPE_FK,
                    "fullCardDesignBlockId"       => self::TYPE_FK,
                    "fullCardLabelDesignBlockId"  => self::TYPE_FK,
                    "fullCardLabelDesignTextId"   => self::TYPE_FK,
                    "fullCardValueDesignBlockId"  => self::TYPE_FK,
                    "fullCardValueDesignTextId"   => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designFields", "shortCardDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignTextId", "designTexts")
            ->createForeignKey("designFields", "shortCardValueDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardValueDesignTextId", "designTexts")
            ->createForeignKey("designFields", "fullCardDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardLabelDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardLabelDesignTextId", "designTexts")
            ->createForeignKey("designFields", "fullCardValueDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardValueDesignTextId", "designTexts")
            ->createTable(
                "fields",
                [
                    "id"            => self::TYPE_PK,
                    "designFieldId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("fields", "designFieldId", "designFields")
            ->createTable(
                "fieldInstances",
                [
                    "id"             => self::TYPE_PK,
                    "fieldsId"       => self::TYPE_FK,
                    "sort"           => self::TYPE_SMALLINT,
                    "label"          => self::TYPE_STRING,
                    "type"           => self::TYPE_TINYINT_UNSIGNED,
                    "validationType" => self::TYPE_TINYINT_UNSIGNED,
                    "isHideForShort" => self::TYPE_BOOL,
                    "isShowEmpty"    => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("fieldInstances", "fieldsId", "fields")
            ->createIndex("fieldInstances", "sort")
            ->createTable(
                "fieldGroups",
                [
                    "id" => self::TYPE_PK,
                ]
            )
            ->createTable(
                "fieldValues",
                [
                    "id"              => self::TYPE_PK,
                    "fieldGroupId"    => self::TYPE_FK,
                    "fieldInstanceId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("fieldValues", "fieldGroupId", "fieldGroups")
            ->createForeignKey("fieldValues", "fieldInstanceId", "fieldInstances")
            ->createIndex("fieldValues", "value")
            ->createTable(
                "fieldListValues",
                [
                    "id"              => self::TYPE_PK,
                    "fieldInstanceId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                    "sort"            => self::TYPE_SMALLINT,
                    "isChecked"       => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("fieldListValues", "fieldInstanceId", "fieldInstances")
            ->createIndex("fieldListValues", "sort")
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
            ->createForeignKey("tabValues", "textInstanceId", "textInstances")
            ->createTable(
                "designCatalogs",
                [
                    "id"                                   => self::TYPE_PK,
                    "shortCardDesignBlockId"               => self::TYPE_FK,
                    "shortCardInstanceDesignBlockId"       => self::TYPE_FK,
                    "shortCardTitleDesignBlockId"          => self::TYPE_FK,
                    "shortCardTitleDesignTextId"           => self::TYPE_FK,
                    "shortCardDateDesignTextId"            => self::TYPE_FK,
                    "shortCardPriceDesignBlockId"          => self::TYPE_FK,
                    "shortCardPriceDesignTextId"           => self::TYPE_FK,
                    "shortCardOldPriceDesignBlockId"       => self::TYPE_FK,
                    "shortCardOldPriceDesignTextId"        => self::TYPE_FK,
                    "shortCardDescriptionDesignBlockId"    => self::TYPE_FK,
                    "shortCardDescriptionDesignTextId"     => self::TYPE_FK,
                    "shortCardPaginationDesignBlockId"     => self::TYPE_FK,
                    "shortCardPaginationItemDesignBlockId" => self::TYPE_FK,
                    "shortCardPaginationItemDesignTextId"  => self::TYPE_FK,
                    "fullCardTitleDesignBlockId"           => self::TYPE_FK,
                    "fullCardTitleDesignTextId"            => self::TYPE_FK,
                    "fullCardDateDesignTextId"             => self::TYPE_FK,
                    "fullCardPriceDesignBlockId"           => self::TYPE_FK,
                    "fullCardPriceDesignTextId"            => self::TYPE_FK,
                    "fullCardOldPriceDesignBlockId"        => self::TYPE_FK,
                    "fullCardOldPriceDesignTextId"         => self::TYPE_FK,
                    "fullCardBinButtonDesignBlockId"       => self::TYPE_FK,
                    "fullCardBinButtonDesignTextId"        => self::TYPE_FK,
                    "shortCardViewType"                    => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardDatePosition"                 => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designCatalog", "shortCardDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardInstanceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "shortCardDateDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "shortCardPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "shortCardOldPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardOldPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "shortCardDescriptionDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardDescriptionDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "shortCardPaginationDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardPaginationItemDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "shortCardPaginationItemDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "fullCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "fullCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "fullCardDateDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "fullCardPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "fullCardPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "fullCardOldPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "fullCardOldPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalog", "fullCardBinButtonDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalog", "fullCardBinButtonDesignTextId", "designTexts")
            ->createTable(
                "catalogs",
                [
                    "id"                 => self::TYPE_PK,
                    "imageId"            => self::TYPE_FK,
                    "tabId"              => self::TYPE_FK,
                    "fieldId"            => self::TYPE_FK,
                    "descriptionTextId"  => self::TYPE_FK,
                    "designCatalogId"    => self::TYPE_FK,
                    "hasImages"          => self::TYPE_BOOL,
                    "useAutoload"        => self::TYPE_BOOL,
                    "pageNavigationSize" => self::TYPE_TINYINT_UNSIGNED,
                    "shortCardDateType"  => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardDateType"   => self::TYPE_TINYINT_UNSIGNED,
                    "hasRelations"       => self::TYPE_BOOL,
                    "relationsLabel"     => self::TYPE_STRING,
                    "hasBin"             => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("catalogs", "imageId", "images")
            ->createForeignKey("catalogs", "tabId", "tabs")
            ->createForeignKey("catalogs", "fieldsId", "fields")
            ->createForeignKey("catalogs", "descriptionTextId", "texts")
            ->createForeignKey("catalogs", "designCatalogId", "designCatalogs")
            ->createTable(
                "catalogMenu",
                [
                    "id"        => self::TYPE_PK,
                    "parentId"  => self::TYPE_FK,
                    "seoId"     => self::TYPE_FK,
                    "catalogId" => self::TYPE_FK,
                    "icon"      => self::TYPE_STRING_50,
                    "subName"   => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("catalogMenu", "parentId", "catalogMenu", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("catalogMenu", "seoId", "seo")
            ->createForeignKey("catalogMenu", "catalogId", "catalogs")
            ->createTable(
                "catalogInstances",
                [
                    "id"            => self::TYPE_PK,
                    "seoId"         => self::TYPE_FK,
                    "tabGroupId"    => self::TYPE_FK,
                    "imageAlbumId"  => self::TYPE_FK,
                    "catalogMenuId" => self::TYPE_FK,
                    "fieldGroupId"  => self::TYPE_FK,
                    "price"         => self::TYPE_FLOAT,
                    "oldPrice"      => self::TYPE_FLOAT,
                    "date"          => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey("catalogInstances", "seoId", "seo")
            ->createForeignKey("catalogInstances", "tabGroupId", "tabGroups")
            ->createForeignKey("catalogInstances", "imageAlbumsId", "imageAlbums")
            ->createForeignKey("catalogInstances", "catalogMenuId", "catalogMenu")
            ->createForeignKey("catalogInstances", "fieldGroupId", "fieldGroups")
            ->createIndex("catalogInstances", "price")
            ->createIndex("catalogInstances", "date")
            ->createTable(
                "catalogInstanceLinks",
                [
                    "id"                    => self::TYPE_PK,
                    "catalogInstanceId"     => self::TYPE_FK,
                    "linkCatalogInstanceId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("catalogInstanceLinks", "catalogInstanceId", "catalogInstances")
            ->createForeignKey("catalogInstanceLinks", "linkCatalogInstanceId", "catalogInstances")
            ->createTable(
                "catalogBins",
                [
                    "id"                => self::TYPE_PK,
                    "catalogId"         => self::TYPE_FK,
                    "catalogInstanceId" => self::TYPE_FK,
                    "count"             => self::TYPE_SMALLINT_UNSIGNED,
                    "status"            => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("catalogBin", "catalogId", "catalogs")
            ->createForeignKey("catalogBin", "catalogInstanceId", "catalogInstances")
            ->createIndex("catalogBin", "status")
            ->createTable(
                "catalogOrders",
                [
                    "id"           => self::TYPE_PK,
                    "catalogBinId" => self::TYPE_FK,
                    "formId"       => self::TYPE_FK,
                    "email"        => self::TYPE_STRING_100,
                ]
            )
            ->createForeignKey("catalogOrders", "catalogBinId", "catalogBins")
            ->createForeignKey("catalogOrders", "formId", "forms")
            ->createTable(
                "settings",
                [
                    "id"          => self::TYPE_PK,
                    "iconImageId" => self::TYPE_FK,
                    "seoId"       => self::TYPE_FK,
                ]
            )
            ->createForeignKey("settings", "iconImageId", "images")
            ->createForeignKey("settings", "seoId", "seo");
    }
}