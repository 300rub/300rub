<?php

namespace migrations;

/**
 * Creates images table
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
                "images",
                [
                    "id"                    => "pk",
                    "name"                  => "string",
                    "language"              => "integer",
                    "design_block_id"       => "integer",
                    "design_image_block_id" => "integer",
                    "crop_type"             => "integer",
                    "crop_width"            => "integer",
                    "crop_height"           => "integer",
                    "crop_x"                => "integer",
                    "crop_y"                => "integer",
                    "use_albums"            => "boolean",
                ]
            )
            ->createIndex("images_design_block_id", "images", "design_block_id")
            ->createIndex("images_design_image_block_id", "images", "design_image_block_id")
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
                    "file_name"      => "string",
                    "image_album_id" => "integer",
                    "is_cover"       => "boolean",
                    "sort"           => "integer",
                    "alt"            => "text",
                    "width"          => "integer",
                    "height"         => "integer",
                    "x1"             => "integer",
                    "y1"             => "integer",
                    "x2"             => "integer",
                    "y2"             => "integer",
                    "thumb_width"    => "integer",
                    "thumb_height"   => "integer",
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