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
                    "designBlockId"      => self::TYPE_INT,
                    "imageDesignBlockId" => self::TYPE_INT,
                    "designTextId"       => self::TYPE_INT,
                    "alignment"          => self::TYPE_TINYINT,
                ]
            )
            ->createForeignKey("designImageSimples", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "imageDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "designTextId", "designTexts")
            ->createTable(
                "designImageZooms",
                [
                    "id"                   => self::TYPE_PK,
                    "designBlockId"        => self::TYPE_INT,
                    "hasScroll"            => self::TYPE_BOOL,
                    "thumbsAlignment"      => self::TYPE_TINYINT,
                    "descriptionAlignment" => self::TYPE_TINYINT,
                    "effect"               => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("designImageZooms", "designBlockId", "designBlocks")
            ->createTable(
                "designImageSliders",
                [
                    "id"                       => self::TYPE_PK,
                    "designBlockId"            => self::TYPE_INT,
                    "navigationDesignBlockId"  => self::TYPE_INT,
                    "descriptionDesignBlockId" => self::TYPE_INT,
                    "effect"                   => self::TYPE_SMALLINT,
                    "hasAutoPlay"              => self::TYPE_BOOL,
                    "playSpeed"                => self::TYPE_TINYINT,
                    "navigationAlignment"      => self::TYPE_TINYINT,
                    "descriptionAlignment"     => self::TYPE_TINYINT,
                ]
            )
            ->createForeignKey("designImageSliders", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "navigationDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "descriptionDesignBlockId", "designBlocks")
            ->createTable(
                "images",
                [
                    "id"                  => self::TYPE_PK,
                    "designBlockId"       => self::TYPE_INT,
                    "designImageSliderId" => self::TYPE_INT,
                    "designImageZoomId"   => self::TYPE_INT,
                    "designImageSimpleId" => self::TYPE_INT,
                    "name"                => self::TYPE_STRING,
                    "language"            => self::TYPE_TINYINT,
                    "type"                => self::TYPE_TINYINT,
                    "autoCropType"        => self::TYPE_TINYINT,
                    "cropWidth"           => self::TYPE_SMALLINT,
                    "cropHeight"          => self::TYPE_SMALLINT,
                    "cropX"               => self::TYPE_INT,
                    "cropY"               => self::TYPE_INT,
                    "thumbAutoCropType"   => self::TYPE_TINYINT,
                    "thumbCropX"          => self::TYPE_SMALLINT,
                    "thumbCropY"          => self::TYPE_SMALLINT,
                    "useAlbums"           => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("images", "designBlockId", "designBlocks")
            ->createForeignKey("images", "designImageSliderId", "designBlocks")
            ->createForeignKey("images", "designImageZoomId", "designBlocks")
            ->createForeignKey("images", "designImageSimpleId", "designBlocks")
            ->createTable(
                "imageAlbums",
                [
                    "id"      => self::TYPE_PK,
                    "imageId" => self::TYPE_INT,
                    "name"    => self::TYPE_STRING,
                    "sort"    => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("imageAlbums", "imageId", "images", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageAlbums", "sort")
            ->createTable(
                "imageInstances",
                [
                    "id"           => self::TYPE_PK,
                    "imageAlbumId" => self::TYPE_INT,
                    "isCover"      => self::TYPE_BOOL,
                    "sort"         => self::TYPE_SMALLINT,
                    "fileName"     => self::TYPE_STRING_25,
                    "alt"          => self::TYPE_TEXT,
                    "width"        => self::TYPE_SMALLINT,
                    "height"       => self::TYPE_SMALLINT,
                    "x1"           => self::TYPE_SMALLINT,
                    "y1"           => self::TYPE_SMALLINT,
                    "x2"           => self::TYPE_SMALLINT,
                    "y2"           => self::TYPE_SMALLINT,
                    "thumbX1"      => self::TYPE_SMALLINT,
                    "thumbY1"      => self::TYPE_SMALLINT,
                    "thumbX2"      => self::TYPE_SMALLINT,
                    "thumbY2"      => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("imageInstances", "imageAlbumId", "imageAlbums", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageInstances", "isCover")
            ->createIndex("imageInstances", "sort");
    }
}