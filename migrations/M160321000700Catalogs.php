<?php

namespace testS\migrations;

use testS\migrations\_abstract\AbstractMigration;

/**
 * Creates catalog tables
 */
class M160321000700Catalogs extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->_createDesignCatalogsTable()
            ->_createDesignCatalogsForeignKeys1()
            ->_createDesignCatalogsForeignKeys2()
            ->_createCatalogs()
            ->_createCatalogMenu()
            ->_createCatalogInstances()
            ->_createCatalogInstanceLinks()
            ->_createCatalogBins()
            ->_createCatalogOrders();
    }

    /**
     * Creates designCatalogs table
     *
     * @return M160321000700Catalogs
     */
    private function _createDesignCatalogsTable()
    {
        return $this
            ->createTable(
                'designCatalogs',
                [
                    'id'
                    => self::TYPE_PK,
                    'shortCardContainerDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardInstanceDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardTitleDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardTitleDesignTextId'
                    => self::TYPE_FK,
                    'shortCardDateDesignTextId'
                    => self::TYPE_FK,
                    'shortCardPriceDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardPriceDesignTextId'
                    => self::TYPE_FK,
                    'shortCardOldPriceDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardOldPriceDesignTextId'
                    => self::TYPE_FK,
                    'shortCardDescriptionDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardDescriptionDesignTextId'
                    => self::TYPE_FK,
                    'shortCardPaginationDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardPaginationItemDesignBlockId'
                    => self::TYPE_FK,
                    'shortCardPaginationItemDesignTextId'
                    => self::TYPE_FK,
                    'fullCardContainerDesignBlockId'
                    => self::TYPE_FK,
                    'fullCardTitleDesignBlockId'
                    => self::TYPE_FK,
                    'fullCardTitleDesignTextId'
                    => self::TYPE_FK,
                    'fullCardDateDesignTextId'
                    => self::TYPE_FK,
                    'fullCardPriceDesignBlockId'
                    => self::TYPE_FK,
                    'fullCardPriceDesignTextId'
                    => self::TYPE_FK,
                    'fullCardOldPriceDesignBlockId'
                    => self::TYPE_FK,
                    'fullCardOldPriceDesignTextId'
                    => self::TYPE_FK,
                    'fullCardBinButtonDesignBlockId'
                    => self::TYPE_FK,
                    'fullCardBinButtonDesignTextId'
                    => self::TYPE_FK,
                    'shortCardViewType'
                    => self::TYPE_TINYINT_UNSIGNED,
                    'fullCardImagesPosition'
                    => self::TYPE_TINYINT_UNSIGNED,
                    'fullCardDatePosition'
                    => self::TYPE_TINYINT_UNSIGNED,
                ]
            );
    }

    /**
     * Creates designCatalogs foreign keys
     *
     * @return M160321000700Catalogs
     */
    private function _createDesignCatalogsForeignKeys1()
    {
        return $this
            ->createForeignKey(
                'designCatalogs',
                'shortCardContainerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardInstanceDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardTitleDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardTitleDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardDateDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardPriceDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardPriceDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardOldPriceDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardOldPriceDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardDescriptionDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardDescriptionDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardPaginationDesignBlockId',
                'designBlocks'
            );
    }

    /**
     * Creates designCatalogs foreign keys
     *
     * @return M160321000700Catalogs
     */
    private function _createDesignCatalogsForeignKeys2()
    {
        return $this
            ->createForeignKey(
                'designCatalogs',
                'shortCardPaginationItemDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'shortCardPaginationItemDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardContainerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardTitleDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardTitleDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardDateDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardPriceDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardPriceDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardOldPriceDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardOldPriceDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardBinButtonDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designCatalogs',
                'fullCardBinButtonDesignTextId',
                'designTexts'
            );
    }

    /**
     * Creates catalogs table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogs()
    {
        return $this
            ->createTable(
                'catalogs',
                [
                    'id'                 => self::TYPE_PK,
                    'imageId'            => self::TYPE_FK,
                    'tabId'              => self::TYPE_FK,
                    'fieldId'            => self::TYPE_FK,
                    'descriptionTextId'  => self::TYPE_FK,
                    'designCatalogId'    => self::TYPE_FK,
                    'hasImages'          => self::TYPE_BOOL,
                    'useAutoload'        => self::TYPE_BOOL,
                    'pageNavigationSize' => self::TYPE_TINYINT_UNSIGNED,
                    'shortCardDateType'  => self::TYPE_TINYINT_UNSIGNED,
                    'fullCardDateType'   => self::TYPE_TINYINT_UNSIGNED,
                    'hasRelations'       => self::TYPE_BOOL,
                    'relationsLabel'     => self::TYPE_STRING,
                    'hasBin'             => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey(
                'catalogs',
                'imageId',
                'images'
            )
            ->createForeignKey(
                'catalogs',
                'tabId',
                'tabs'
            )
            ->createForeignKey(
                'catalogs',
                'fieldId',
                'fields'
            )
            ->createForeignKey(
                'catalogs',
                'descriptionTextId',
                'texts'
            )
            ->createForeignKey(
                'catalogs',
                'designCatalogId',
                'designCatalogs'
            );
    }

    /**
     * Creates catalogMenu table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogMenu()
    {
        return $this
            ->createTable(
                'catalogMenu',
                [
                    'id'        => self::TYPE_PK,
                    'parentId'  => self::TYPE_FK_NULL,
                    'seoId'     => self::TYPE_FK,
                    'catalogId' => self::TYPE_FK,
                    'icon'      => self::TYPE_STRING_50,
                    'subName'   => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'catalogMenu',
                'parentId',
                'catalogMenu',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey('catalogMenu', 'seoId', 'seo')
            ->createForeignKey(
                'catalogMenu',
                'catalogId',
                'catalogs',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates catalogInstances table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogInstances()
    {
        return $this
            ->createTable(
                'catalogInstances',
                [
                    'id'            => self::TYPE_PK,
                    'seoId'         => self::TYPE_FK,
                    'tabGroupId'    => self::TYPE_FK,
                    'imageGroupId'  => self::TYPE_FK,
                    'catalogMenuId' => self::TYPE_FK,
                    'fieldGroupId'  => self::TYPE_FK,
                    'price'         => self::TYPE_FLOAT,
                    'oldPrice'      => self::TYPE_FLOAT,
                    'date'          => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey(
                'catalogInstances',
                'seoId',
                'seo'
            )
            ->createForeignKey(
                'catalogInstances',
                'tabGroupId',
                'tabGroups'
            )
            ->createForeignKey(
                'catalogInstances',
                'imageGroupId',
                'imageGroups'
            )
            ->createForeignKey(
                'catalogInstances',
                'catalogMenuId',
                'catalogMenu',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'catalogInstances',
                'fieldGroupId',
                'fieldGroups'
            )
            ->createIndex(
                'catalogInstances',
                'price'
            )
            ->createIndex('catalogInstances', 'date');
    }

    /**
     * Creates catalogInstanceLinks table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogInstanceLinks()
    {
        return $this
            ->createTable(
                'catalogInstanceLinks',
                [
                    'id'                    => self::TYPE_PK,
                    'catalogInstanceId'     => self::TYPE_FK,
                    'linkCatalogInstanceId' => self::TYPE_FK,
                ]
            )
            ->createForeignKey(
                'catalogInstanceLinks',
                'catalogInstanceId',
                'catalogInstances',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'catalogInstanceLinks',
                'linkCatalogInstanceId',
                'catalogInstances',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createUniqueIndex(
                'catalogInstanceLinks',
                'catalogInstanceLinks_catalogInstanceId_linkCatalogInstanceId',
                'catalogInstanceId,linkCatalogInstanceId'
            );
    }

    /**
     * Creates catalogBins table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogBins()
    {
        return $this
            ->createTable(
                'catalogBins',
                [
                    'id'                => self::TYPE_PK,
                    'catalogId'         => self::TYPE_FK,
                    'catalogInstanceId' => self::TYPE_FK,
                    'count'             => self::TYPE_SMALLINT_UNSIGNED,
                    'status'            => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'catalogBins',
                'catalogId',
                'catalogs',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'catalogBins',
                'catalogInstanceId',
                'catalogInstances',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex('catalogBins', 'status');
    }

    /**
     * Creates catalogOrders table
     *
     * @return M160321000700Catalogs
     */
    private function _createCatalogOrders()
    {
        return $this
            ->createTable(
                'catalogOrders',
                [
                    'id'           => self::TYPE_PK,
                    'catalogBinId' => self::TYPE_FK,
                    'formId'       => self::TYPE_FK,
                    'email'        => self::TYPE_STRING_100,
                ]
            )
            ->createForeignKey(
                'catalogOrders',
                'catalogBinId',
                'catalogBins',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'catalogOrders',
                'formId',
                'forms',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }
}
