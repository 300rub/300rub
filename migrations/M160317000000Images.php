<?php

namespace migrations;

/**
 * Creates image tables
 *
 * @package migrations
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
            ->createIndex("designImageSimplesDesignBlockId", "designImageSimples", "designBlockId")
            ->createIndex("designImageSimplesImageDesignBlockId", "designImageSimples", "imageDesignBlockId")
            ->createIndex("designImageSimplesDesignTextId", "designImageSimples", "designTextId")
            ->createTable(
                "designImageZooms",
                [
                    "id"                   => "pk",
                    "designBlockId"        => "integer",
                    "isScroll"             => "boolean",
                    "thumbsAlignment"      => "integer",
                    "descriptionAlignment" => "integer",
                    "effect"               => "integer",
                ]
            )
            ->createIndex("designImageZoomsDesignBlockId", "designImageZooms", "designBlockId")
            ->createTable(
                "designImageSliders",
                [
                    "id"                       => "pk",
                    "designBlockId"            => "integer",
                    "effect"                   => "integer",
                    "isAutoPlay"               => "boolean",
                    "playSpeed"                => "integer",
                    "navigationDesignBlockId"  => "integer",
                    "navigationAlignment"      => "integer",
                    "descriptionDesignBlockId" => "integer",
                    "descriptionAlignment"     => "integer",
                ]
            )
            ->createIndex("designImageSlidersDesignBlockId", "designImageSliders", "designBlockId")
            ->createIndex(
                "designImageSlidersNavigationDesignBlockId",
                "designImageSliders",
                "navigationDesignBlockId"
            )
            ->createIndex(
                "designImageSlidersDescriptionDesignBlockId",
                "designImageSliders",
                "descriptionDesignBlockId"
            )
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
            ->createIndex("imagesDesignBlockId", "images", "designBlockId")
            ->createIndex("imagesDesignImageSliderId", "images", "designImageSliderId")
            ->createIndex("imagesDesignImageZoomId", "images", "designImageZoomId")
            ->createIndex("imagesDesignImageSimpleId", "images", "designImageSimpleId")
            ->createTable(
                "imageAlbums",
                [
                    "id"      => "pk",
                    "name"    => "string",
                    "imageId" => "integer",
                    "sort"    => "integer",
                ]
            )
            ->createIndex("imageAlbumsImageId", "imageAlbums", "imageId")
            ->createIndex("imageAlbumsSort", "imageAlbums", "sort")
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
            ->createIndex("imageInstancesImageAlbumId", "imageInstances", "imageAlbumId")
            ->createIndex("imageInstancesIsCover", "imageInstances", "isCover")
            ->createIndex("imageInstancesSort", "imageInstances", "sort");
    }
}