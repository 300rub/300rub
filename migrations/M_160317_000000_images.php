<?php

namespace migrations;

/**
 * Creates image tables
 *
 * @package migrations
 */
class M_160317_000000_images extends AbstractMigration
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
                    "id"                    => "pk",
                    "alignment"             => "integer",
                    "designBlockId"       => "integer",
                    "imageDesignBlockId" => "integer",
                    "designTextId"        => "integer",
                ]
            )
            ->createIndex("designImageSimplesDesignBlockId", "designImageSimples", "designBlockId")
            ->createIndex("designImageSimplesImageDesignBlockId", "designImageSimples", "imageDesignBlockId")
            ->createIndex("designImageSimplesDesignTextId", "designImageSimples", "designTextId")
            ->createTable(
                "designImageZooms",
                [
                    "id"                    => "pk",
                    "designBlockId"       => "integer",
                    "isScroll"             => "boolean",
                    "thumbsAlignment"      => "integer",
                    "descriptionAlignment" => "integer",
                    "effect"                => "integer",
                ]
            )
            ->createIndex("designImageZoomsDesignBlockId", "designImageZooms", "designBlockId")
            ->createTable(
                "designImageSliders",
                [
                    "id"                          => "pk",
                    "designBlockId"             => "integer",
                    "effect"                      => "integer",
                    "isAutoPlay"                => "boolean",
                    "playSpeed"                  => "integer",
                    "navigationDesignBlockId"  => "integer",
                    "navigationAlignment"        => "integer",
                    "descriptionDesignBlockId" => "integer",
                    "descriptionAlignment"       => "integer",
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
                    "id"                     => "pk",
                    "name"                   => "string",
                    "language"               => "integer",
                    "designBlockId"        => "integer",
                    "designImageSliderId" => "integer",
                    "designImageZoomId"   => "integer",
                    "designImageSimpleId" => "integer",
                    "type"                   => "integer",
                    "useCrop"               => "boolean",
                    "auto_crop_type"         => "integer",
                    "crop_width"             => "integer",
                    "crop_height"            => "integer",
                    "crop_x"                 => "integer",
                    "crop_y"                 => "integer",
                    "thumb_auto_crop_type"   => "integer",
                    "thumb_crop_width"       => "integer",
                    "thumb_crop_height"      => "integer",
                    "use_albums"             => "boolean",
                ]
            )
            ->createIndex("images_designBlockId", "images", "designBlockId")
            ->createIndex("images_designImageSliderId", "images", "designImageSliderId")
            ->createIndex("images_designImageZoomId", "images", "designImageZoomId")
            ->createIndex("images_designImageSimpleId", "images", "designImageSimpleId")
            ->createTable(
                "image_albums",
                [
                    "id"       => "pk",
                    "name"     => "string",
                    "image_id" => "integer",
                    "sort"     => "integer",
                ]
            )
            ->createIndex("image_albums_image_id", "image_albums", "image_id")
            ->createIndex("image_albums_sort", "image_albums", "sort")
            ->createTable(
                "image_instances",
                [
                    "id"             => "pk",
                    "image_album_id" => "integer",
                    "is_cover"       => "boolean",
                    "sort"           => "integer",
                    "file_name"      => "string",
                    "alt"            => "text",
                    "width"          => "integer",
                    "height"         => "integer",
                    "x1"             => "integer",
                    "y1"             => "integer",
                    "x2"             => "integer",
                    "y2"             => "integer",
                    "thumb_x1"       => "integer",
                    "thumb_y1"       => "integer",
                    "thumb_x2"       => "integer",
                    "thumb_y2"       => "integer",
                ]
            )
            ->createIndex("image_instances_image_album_id", "image_instances", "image_album_id")
            ->createIndex("image_instances_is_cover", "image_instances", "is_cover")
            ->createIndex("image_instances_sort", "image_instances", "sort");
    }
}