<?php

namespace testS\migrations;

/**
 * Creates search tables
 *
 * @package testS\migrations
 */
class M160321000400Search extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
//        designFields
//        - id
//        - shortCardDesignBlockId
//        - shortCardLabelDesignBlockId
//        - shortCardLabelDesignTextId
//        - shortCardValueDesignBlockId
//        - shortCardValueDesignTextId
//        - fullCardDesignBlockId
//        - fullCardLabelDesignBlockId
//        - fullCardLabelDesignTextId
//        - fullCardValueDesignBlockId
//        - fullCardValueDesignTextId
//
//fields
//-id
//- designFieldId
//
//fieldInstances
//- id
//- fieldsId
//- sort
//- label
//- type
//- validationType
//- isHideForShort
//- isShowEmpty
//
//fieldGroups
//- id
//
//fieldValues
//- id
//- fieldGroupId
//- fieldInstanceId
//- value
//
//fieldListValues
//- id
//- fieldInstanceId
//- sort
//- value
//- isChecked
//
//designTabs
//- id
//- designBlockId
//- tabDesignBlockId
//- tabDesignTextId
//- contentDesignBlockId
//
//tabs
//- id
//- designTabsId
//- textId
//- isShowEmpty
//- isLazyLoad
//
//tabGroups
//- id
//
//tabInstances
//- id
//- tabId
//- sort
//- label
//
//tabValues
//- id
//- tabGroupId
//- tabInstanceId
//- textInstanceId
//
//designCatalog
//- id
//- shortCardDesignBlockId
//- shortCardInstanceDesignBlockId
//- shortCardTitleDesignBlockId
//- shortCardTitleDesignTextId
//- shortCardDateDesignTextId
//- shortCardPriceDesignBlockId
//- shortCardPriceDesignTextId
//- shortCardOldPriceDesignBlockId
//- shortCardOldPriceDesignTextId
//- shortCardDescriptionDesignBlockId
//- shortCardDescriptionDesignTextId
//- shortCardPaginationDesignBlockId
//- shortCardPaginationItemDesignBlockId
//- shortCardPaginationItemDesignTextId
//
//- fullCardTitleDesignBlockId
//- fullCardTitleDesignTextId
//- fullCardDateDesignTextId
//- fullCardPriceDesignBlockId
//- fullCardPriceDesignTextId
//- fullCardOldPriceDesignBlockId
//- fullCardOldPriceDesignTextId
//- fullCardBinButtonDesignBlockId
//- fullCardBinButtonDesignTextId
//
//- shortCardViewType
//- fullCardDatePosition
//
//catalog
//- id
//- imageId
//- tabId
//- fieldsId
//- descriptionTextId
//- catalogDesignId
//- hasImages
//- useAutoload
//- pageNavigationSize
//- shortCardDateType
//- fullCardDateType
//- hasRelations
//- relationsLabel
//- hasBin
//
//catalogMenu
//- id
//- parentId
//- seoId
//- catalogId
//- icon
//- subName
//
//catalogInstances
//-id
//-seoId
//-tabGroupId
//-imageAlbumsId
//- catalogMenuId
//- fieldGroupId
//- price
//- oldPrice
//- date
//
//catalogInstanceLinks
//- id
//- catalogInstanceId
//- linkCatalogInstanceId
//
//catalogBin
//- id
//- catalogId
//- catalogInstanceId
//- count
//- status
//
//catalogOrder
//- id
//- catalogBinId
//- formId
//- email
//
//
//settings
//- id
//- iconImageId
//- seoId
    }
}