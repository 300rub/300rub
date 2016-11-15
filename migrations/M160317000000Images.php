<?php

namespace testS\migrations;

/**
 * Creates image tables
 *
 * @package testS\migrations
 */
class M160317000000Images extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designImageSimples",
                [
                    "id"                 => self::TYPE_PK,
                    "designBlockId"      => self::TYPE_FK,
                    "imageDesignBlockId" => self::TYPE_FK,
                    "designTextId"       => self::TYPE_FK,
                    "alignment"          => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designImageSimples", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "imageDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "designTextId", "designTexts")
            ->createTable(
                "designImageZooms",
                [
                    "id"                   => self::TYPE_PK,
                    "designBlockId"        => self::TYPE_FK,
                    "hasScroll"            => self::TYPE_BOOL,
                    "thumbsAlignment"      => self::TYPE_TINYINT_UNSIGNED,
                    "descriptionAlignment" => self::TYPE_TINYINT_UNSIGNED,
                    "effect"               => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designImageZooms", "designBlockId", "designBlocks")
            ->createTable(
                "designImageSliders",
                [
                    "id"                       => self::TYPE_PK,
                    "designBlockId"            => self::TYPE_FK,
                    "navigationDesignBlockId"  => self::TYPE_FK,
                    "descriptionDesignBlockId" => self::TYPE_FK,
                    "effect"                   => self::TYPE_TINYINT_UNSIGNED,
                    "hasAutoPlay"              => self::TYPE_BOOL,
                    "playSpeed"                => self::TYPE_TINYINT_UNSIGNED,
                    "navigationAlignment"      => self::TYPE_TINYINT_UNSIGNED,
                    "descriptionAlignment"     => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designImageSliders", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "navigationDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "descriptionDesignBlockId", "designBlocks")
            ->createTable(
                "images",
                [
                    "id"                  => self::TYPE_PK,
                    "designBlockId"       => self::TYPE_FK,
                    "designImageSliderId" => self::TYPE_FK,
                    "designImageZoomId"   => self::TYPE_FK,
                    "designImageSimpleId" => self::TYPE_FK,
                    "type"                => self::TYPE_TINYINT_UNSIGNED,
                    "autoCropType"        => self::TYPE_TINYINT_UNSIGNED,
                    "cropWidth"           => self::TYPE_SMALLINT_UNSIGNED,
                    "cropHeight"          => self::TYPE_SMALLINT_UNSIGNED,
                    "cropX"               => self::TYPE_INT_UNSIGNED,
                    "cropY"               => self::TYPE_INT_UNSIGNED,
                    "thumbAutoCropType"   => self::TYPE_TINYINT_UNSIGNED,
                    "thumbCropX"          => self::TYPE_SMALLINT_UNSIGNED,
                    "thumbCropY"          => self::TYPE_SMALLINT_UNSIGNED,
                    "useAlbums"           => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("images", "designBlockId", "designBlocks")
            ->createForeignKey("images", "designImageSliderId", "designBlocks")
            ->createForeignKey("images", "designImageZoomId", "designBlocks")
            ->createForeignKey("images", "designImageSimpleId", "designBlocks")
            ->createTable(
                "imageGroups",
                [
                    "id"      => self::TYPE_PK,
                    "imageId" => self::TYPE_FK,
                    "name"    => self::TYPE_STRING,
                    "sort"    => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("imageGroups", "imageId", "images", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageGroups", "sort")
            ->createTable(
                "imageInstances",
                [
                    "id"           => self::TYPE_PK,
                    "imageAlbumId" => self::TYPE_FK,
                    "isCover"      => self::TYPE_BOOL,
                    "sort"         => self::TYPE_SMALLINT,
                    "fileName"     => self::TYPE_STRING_25,
                    "alt"          => self::TYPE_TEXT,
                    "width"        => self::TYPE_SMALLINT_UNSIGNED,
                    "height"       => self::TYPE_SMALLINT_UNSIGNED,
                    "x1"           => self::TYPE_SMALLINT_UNSIGNED,
                    "y1"           => self::TYPE_SMALLINT_UNSIGNED,
                    "x2"           => self::TYPE_SMALLINT_UNSIGNED,
                    "y2"           => self::TYPE_SMALLINT_UNSIGNED,
                    "thumbX1"      => self::TYPE_SMALLINT_UNSIGNED,
                    "thumbY1"      => self::TYPE_SMALLINT_UNSIGNED,
                    "thumbX2"      => self::TYPE_SMALLINT_UNSIGNED,
                    "thumbY2"      => self::TYPE_SMALLINT_UNSIGNED,
                ]
            )
            ->createForeignKey("imageInstances", "imageAlbumId", "imageGroups", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageInstances", "isCover")
            ->createIndex("imageInstances", "sort");
    }
}