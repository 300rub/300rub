<?php

namespace migrations;

/**
 * Creates images table
 *
 * @package migrations
 */
class M_160317_000000_images extends AbstractMigration
{

    public $isSkip = true;

    /**
     * Applies migration
     *
     * @return bool
     */
    public function up()
    {
        $result = $this->createTable(
            "images",
            [
                "id"               => "pk",
                "name"             => "string",
                "language"         => "integer",
                "design_block_id"  => "integer",
                "is_keep_original" => "boolean",
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        if (!$result) {
            return false;
        }
        if (!$this->createIndex("images_design_block_id", "images", "design_block_id")) {
            return false;
        }

        $result = $this->createTable(
            "image_albums",
            [
                "id"       => "pk",
                "name"     => "string",
                "image_id" => "integer",
                "sort"     => "integer",
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        if (!$result) {
            return false;
        }
        if (!$this->createIndex("image_albums_image_id", "image_albums", "image_id")) {
            return false;
        }

        $result = $this->createTable(
            "image_instances",
            [
                "id"             => "pk",
                "file"           => "string",
                "image_album_id" => "integer",
                "sort"           => "integer",
                "alt"            => "string",
                "x1"             => "integer",
                "y1"             => "integer",
                "x2"             => "integer",
                "y2"             => "integer",
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        if (!$result) {
            return false;
        }
        if (!$this->createIndex("image_albums_image_id", "image_albums", "image_id")) {
            return false;
        }

        return true;
    }
}