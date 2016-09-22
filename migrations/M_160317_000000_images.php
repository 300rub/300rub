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
                "design_image_simples",
                [
                    "id"                    => "pk",
                    "alignment"             => "integer",
                    "designBlockId"       => "integer",
                    "image_designBlockId" => "integer",
                    "designTextId"        => "integer",
                ]
            )
            ->createIndex("design_image_simples_designBlockId", "design_image_simples", "designBlockId")
            ->createIndex("design_image_simples_design_image_block_id", "design_image_simples", "design_image_block_id")
            ->createIndex("design_image_simples_designTextId", "design_image_simples", "designTextId")
            ->createTable(
                "design_image_zooms",
                [
                    "id"                    => "pk",
                    "designBlockId"       => "integer",
                    "is_scroll"             => "boolean",
                    "thumbs_alignment"      => "integer",
                    "description_alignment" => "integer",
                    "effect"                => "integer",
                ]
            )
            ->createIndex("design_image_zooms_designBlockId", "design_image_zooms", "designBlockId")
            ->createTable(
                "design_image_sliders",
                [
                    "id"                          => "pk",
                    "designBlockId"             => "integer",
                    "effect"                      => "integer",
                    "is_auto_play"                => "boolean",
                    "play_speed"                  => "integer",
                    "navigation_designBlockId"  => "integer",
                    "navigation_alignment"        => "integer",
                    "description_designBlockId" => "integer",
                    "description_alignment"       => "integer",
                ]
            )
            ->createIndex("design_image_sliders_designBlockId", "design_image_sliders", "designBlockId")
            ->createIndex(
                "design_image_sliders_navigation_designBlockId",
                "design_image_sliders",
                "navigation_designBlockId"
            )
            ->createIndex(
                "design_image_sliders_description_designBlockId",
                "design_image_sliders",
                "description_designBlockId"
            )
            ->createTable(
                "images",
                [
                    "id"                     => "pk",
                    "name"                   => "string",
                    "language"               => "integer",
                    "designBlockId"        => "integer",
                    "design_image_slider_id" => "integer",
                    "design_image_zoom_id"   => "integer",
                    "design_image_simple_id" => "integer",
                    "type"                   => "integer",
                    "use_crop"               => "boolean",
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