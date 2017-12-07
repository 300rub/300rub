<?php

namespace testS\migrations;

/**
 * Creates records tables
 *
 * @package testS\migrations
 */
class M160321000100Records extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designRecords",
                [
                    "id"                                   => self::TYPE_PK,
                    "shortCardContainerDesignBlockId"      => self::TYPE_FK,
                    "shortCardInstanceDesignBlockId"       => self::TYPE_FK,
                    "shortCardTitleDesignBlockId"          => self::TYPE_FK,
                    "shortCardTitleDesignTextId"           => self::TYPE_FK,
                    "shortCardDateDesignTextId"            => self::TYPE_FK,
                    "shortCardDescriptionDesignBlockId"    => self::TYPE_FK,
                    "shortCardDescriptionDesignTextId"     => self::TYPE_FK,
                    "shortCardPaginationDesignBlockId"     => self::TYPE_FK,
                    "shortCardPaginationItemDesignBlockId" => self::TYPE_FK,
                    "shortCardPaginationItemDesignTextId"  => self::TYPE_FK,
                    "fullCardTitleDesignBlockId"           => self::TYPE_FK,
                    "fullCardTitleDesignTextId"            => self::TYPE_FK,
                    "fullCardDateDesignTextId"             => self::TYPE_FK,
                    "shortCardViewType"                    => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardImagesPosition"               => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardDatePosition"                 => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designRecords", "shortCardContainerDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardInstanceDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designRecords", "shortCardDateDesignTextId", "designTexts")
            ->createForeignKey("designRecords", "shortCardDescriptionDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardDescriptionDesignTextId", "designTexts")
            ->createForeignKey("designRecords", "shortCardPaginationDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardPaginationItemDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "shortCardPaginationItemDesignTextId", "designTexts")
            ->createForeignKey("designRecords", "fullCardTitleDesignBlockId", "designBlocks")
            ->createForeignKey("designRecords", "fullCardTitleDesignTextId", "designTexts")
            ->createForeignKey("designRecords", "fullCardDateDesignTextId", "designTexts")
            ->createTable(
                "records",
                [
                    "id"                 => self::TYPE_PK,
                    "coverImageId"       => self::TYPE_FK,
                    "imagesImageId"      => self::TYPE_FK,
                    "descriptionTextId"  => self::TYPE_FK,
                    "textTextId"         => self::TYPE_FK,
                    "designRecordsId"    => self::TYPE_FK,
                    "hasCover"           => self::TYPE_BOOL,
                    "hasImages"          => self::TYPE_BOOL,
                    "hasCoverZoom"       => self::TYPE_BOOL,
                    "hasDescription"     => self::TYPE_BOOL,
                    "useAutoload"        => self::TYPE_BOOL,
                    "pageNavigationSize" => self::TYPE_TINYINT_UNSIGNED,
                    "shortCardDateType"  => self::TYPE_TINYINT_UNSIGNED,
                    "fullCardDateType"   => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("records", "coverImageId", "images")
            ->createForeignKey("records", "imagesImageId", "images")
            ->createForeignKey("records", "descriptionTextId", "texts")
            ->createForeignKey("records", "textTextId", "texts")
            ->createForeignKey("records", "designRecordsId", "designRecords")
            ->createTable(
                "designRecordClones",
                [
                    "id"                       => self::TYPE_PK,
                    "containerDesignBlockId"   => self::TYPE_FK,
                    "instanceDesignBlockId"    => self::TYPE_FK,
                    "titleDesignBlockId"       => self::TYPE_FK,
                    "titleDesignTextId"        => self::TYPE_FK,
                    "dateDesignTextId"         => self::TYPE_FK,
                    "descriptionDesignBlockId" => self::TYPE_FK,
                    "descriptionDesignTextId"  => self::TYPE_FK,
                    "viewType"                 => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designRecordClones", "containerDesignBlockId", "designBlocks")
            ->createForeignKey("designRecordClones", "instanceDesignBlockId", "designBlocks")
            ->createForeignKey("designRecordClones", "titleDesignBlockId", "designBlocks")
            ->createForeignKey("designRecordClones", "titleDesignTextId", "designTexts")
            ->createForeignKey("designRecordClones", "dateDesignTextId", "designTexts")
            ->createForeignKey("designRecordClones", "descriptionDesignBlockId", "designBlocks")
            ->createForeignKey("designRecordClones", "descriptionDesignTextId", "designTexts")
            ->createTable(
                "recordClones",
                [
                    "id"                  => self::TYPE_PK,
                    "recordId"            => self::TYPE_FK,
                    "coverImageId"        => self::TYPE_FK,
                    "descriptionTextId"   => self::TYPE_FK,
                    "designRecordCloneId" => self::TYPE_FK,
                    "hasCover"            => self::TYPE_BOOL,
                    "hasCoverZoom"        => self::TYPE_BOOL,
                    "hasDescription"      => self::TYPE_BOOL,
                    "dateType"            => self::TYPE_TINYINT_UNSIGNED,
                    "maxCount"            => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("recordClones", "recordId", "records")
            ->createForeignKey("recordClones", "coverImageId", "images")
            ->createForeignKey("recordClones", "descriptionTextId", "texts")
            ->createForeignKey("recordClones", "designRecordCloneId", "designRecordClones")
            ->createTable(
                "recordInstances",
                [
                    "id"                        => self::TYPE_PK,
                    "recordId"                  => self::TYPE_FK,
                    "seoId"                     => self::TYPE_FK,
                    "textTextInstanceId"        => self::TYPE_FK,
                    "descriptionTextInstanceId" => self::TYPE_FK,
                    "imageGroupId"              => self::TYPE_FK,
                    "coverImageInstanceId"      => self::TYPE_FK,
                    "date"                      => self::TYPE_DATETIME,
                    "sort"                      => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("recordInstances", "recordId", "records", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("recordInstances", "seoId", "seo")
            ->createForeignKey("recordInstances", "textTextInstanceId", "textInstances")
            ->createForeignKey("recordInstances", "descriptionTextInstanceId", "textInstances")
            ->createForeignKey("recordInstances", "imageGroupId", "imageGroups")
            ->createForeignKey("recordInstances", "coverImageInstanceId", "imageInstances")
            ->createIndex("recordInstances", "date")
            ->createIndex("recordInstances", "sort");
    }
}