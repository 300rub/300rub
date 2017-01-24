<?php

namespace testS\migrations;

/**
 * Creates catalog tables
 *
 * @package testS\migrations
 */
class M160321000700Catalogs extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designCatalogs",
                [
                    "id"                                   => self::TYPE_PK,
                    "shortCardContainerDesignBlockId"      => self::TYPE_FK,
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
                    "fullCardContainerDesignBlockId"       => self::TYPE_FK,
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
                    "fullCardImagesPosition"               => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardDatePosition"                 => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designCatalogs", "shortCardContainerDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardInstanceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "shortCardDateDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "shortCardPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "shortCardOldPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardOldPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "shortCardDescriptionDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardDescriptionDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "shortCardPaginationDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardPaginationItemDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "shortCardPaginationItemDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "fullCardContainerDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "fullCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "fullCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "fullCardDateDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "fullCardPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "fullCardPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "fullCardOldPriceDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "fullCardOldPriceDesignTextId", "designTexts")
            ->createForeignKey("designCatalogs", "fullCardBinButtonDesignBlockId", "designBlocks")
            ->createForeignKey("designCatalogs", "fullCardBinButtonDesignTextId", "designTexts")
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
            ->createForeignKey("catalogs", "fieldId", "fields")
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
                    "imageGroupId"  => self::TYPE_FK,
                    "catalogMenuId" => self::TYPE_FK,
                    "fieldGroupId"  => self::TYPE_FK,
                    "price"         => self::TYPE_FLOAT,
                    "oldPrice"      => self::TYPE_FLOAT,
                    "date"          => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey("catalogInstances", "seoId", "seo")
            ->createForeignKey("catalogInstances", "tabGroupId", "tabGroups")
            ->createForeignKey("catalogInstances", "imageGroupId", "imageGroups")
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
            ->createUniqueIndex(
                "catalogInstanceLinks",
                "catalogInstanceLinks_catalogInstanceId_linkCatalogInstanceId",
                "catalogInstanceId,linkCatalogInstanceId"
            )
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
            ->createForeignKey("catalogBins", "catalogId", "catalogs")
            ->createForeignKey("catalogBins", "catalogInstanceId", "catalogInstances")
            ->createIndex("catalogBins", "status")
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
            ->createForeignKey("catalogOrders", "formId", "forms");
    }
}