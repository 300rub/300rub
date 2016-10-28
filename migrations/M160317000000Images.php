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
                    "id"                 => "pk",
                    "alignment"          => "integer",
                    "designBlockId"      => "integer",
                    "imageDesignBlockId" => "integer",
                    "designTextId"       => "integer",
                ]
            )
            ->createForeignKey("designImageSimples", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "imageDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSimples", "designTextId", "designTexts")
            ->createTable(
                "designImageZooms",
                [
                    "id"                   => "pk",
                    "designBlockId"        => "integer",
                    "hasScroll"            => "boolean",
                    "thumbsAlignment"      => "integer",
                    "descriptionAlignment" => "integer",
                    "effect"               => "integer",
                ]
            )
            ->createForeignKey("designImageZooms", "designBlockId", "designBlocks")
            ->createTable(
                "designImageSliders",
                [
                    "id"                       => "pk",
                    "designBlockId"            => "integer",
                    "effect"                   => "integer",
                    "hasAutoPlay"              => "boolean",
                    "playSpeed"                => "integer",
                    "navigationDesignBlockId"  => "integer",
                    "navigationAlignment"      => "integer",
                    "descriptionDesignBlockId" => "integer",
                    "descriptionAlignment"     => "integer",
                ]
            )
            ->createForeignKey("designImageSliders", "designBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "navigationDesignBlockId", "designBlocks")
            ->createForeignKey("designImageSliders", "descriptionDesignBlockId", "designBlocks")
            ->createTable(
                "images",
                [
                    "id"                  => "pk",
                    "name"                => "string",
                    "language"            => "integer",
                    "designBlockId"       => "integer",
                    "designImageSliderId" => "integer",
                    "designImageZoomId"   => "integer",
                    "designImageSimpleId" => "integer",
                    "type"                => "integer",
                    "autoCropType"        => "integer",
                    "cropWidth"           => "integer",
                    "cropHeight"          => "integer",
                    "cropX"               => "integer",
                    "cropY"               => "integer",
                    "thumbAutoCropType"   => "integer",
                    "thumbCropX"          => "integer",
                    "thumbCropY"          => "integer",
                    "useAlbums"           => "boolean",
                ]
            )
            ->createForeignKey("images", "designBlockId", "designBlocks")
            ->createForeignKey("images", "designImageSliderId", "designBlocks")
            ->createForeignKey("images", "designImageZoomId", "designBlocks")
            ->createForeignKey("images", "designImageSimpleId", "designBlocks")
            ->createTable(
                "imageAlbums",
                [
                    "id"      => "pk",
                    "name"    => "string",
                    "imageId" => "integer",
                    "sort"    => "integer",
                ]
            )
            ->createForeignKey("imageAlbums", "imageId", "images", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageAlbums", "sort")
            ->createTable(
                "imageInstances",
                [
                    "id"           => "pk",
                    "imageAlbumId" => "integer",
                    "isCover"      => "boolean",
                    "sort"         => "integer",
                    "fileName"     => "string",
                    "alt"          => "text",
                    "width"        => "integer",
                    "height"       => "integer",
                    "x1"           => "integer",
                    "y1"           => "integer",
                    "x2"           => "integer",
                    "y2"           => "integer",
                    "thumbX1"      => "integer",
                    "thumbY1"      => "integer",
                    "thumbX2"      => "integer",
                    "thumbY2"      => "integer",
                ]
            )
            ->createForeignKey("imageInstances", "imageAlbumId", "imageAlbums", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("imageInstances", "isCover")
            ->createIndex("imageInstances", "sort");
    }
}