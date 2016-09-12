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
                "design_image_zooms",
                [
                    "id"                    => "pk",
                    "design_block_id"       => "integer",
                    "is_scroll"             => "boolean",
                    "has_thumbs"            => "boolean",
                    "thumbs_alignment"      => "integer",
                    "has_description"       => "boolean",
                    "description_alignment" => "integer",
                    "effect"                => "integer",
                ]
            )
            ->createIndex("design_image_zooms_design_block_id", "design_image_zooms", "design_block_id")
            ->createTable(
                "design_image_sliders",
                [
                    "id"                          => "pk",
                    "design_block_id"             => "integer",
                    "effect"                      => "integer",
                    "is_auto_play"                => "boolean",
                    "play_speed"                  => "integer",
                    "navigation_design_block_id"  => "integer",
                    "navigation_alignment"        => "integer",
                    "description_design_block_id" => "integer",
                    "description_alignment"       => "integer",
                ]
            )
            ->createIndex("design_image_sliders_design_block_id", "design_image_sliders", "design_block_id")
            ->createIndex(
                "design_image_sliders_navigation_design_block_id",
                "design_image_sliders",
                "navigation_design_block_id"
            )
            ->createIndex(
                "design_image_sliders_description_design_block_id",
                "design_image_sliders",
                "description_design_block_id"
            )
            ->createTable(
                "images",
                [
                    "id"                     => "pk",
                    "name"                   => "string",
                    "language"               => "integer",
                    "design_block_id"        => "integer",
                    "design_image_slider_id" => "integer",
                    "design_image_zoom_id"   => "integer",
                    "design_image_simple_id" => "integer",
                    "use_crop"               => "boolean",
                    "is_auto_crop"           => "boolean",
                    "crop_type"              => "integer",
                    "crop_width"             => "integer",
                    "crop_height"            => "integer",
                    "crop_x"                 => "integer",
                    "crop_y"                 => "integer",
                    "use_albums"             => "boolean",
                ]
            )
            ->createIndex("images_design_block_id", "images", "design_block_id")
            ->createIndex("images_design_image_slider_id", "images", "design_image_slider_id")
            ->createIndex("images_design_image_zoom_id", "images", "design_image_zoom_id")
            ->createIndex("images_design_image_simple_id", "images", "design_image_simple_id")
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