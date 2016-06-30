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
     *
     * @return bool
     */
    public function up()
    {
        return
            $this->_createImages() === true
            &&  $this->_createImageAlbums() === true
            && $this->_createImageInstances() === true;
    }

    /**
     * Creates "images" table
     *
     * @return bool
     */
    private function _createImages()
    {
        $result = $this->createTable(
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
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        if (!$result) {
            return false;
        }
        if (!$this->createIndex("images_design_block_id", "images", "design_block_id")) {
            return false;
        }
        if (!$this->createIndex("images_design_image_block_id", "images", "design_image_block_id")) {
            return false;
        }

        return true;
    }

    /**
     * Creates "image_albums" table
     *
     * @return bool
     */
    private function _createImageAlbums()
    {
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
        if (!$this->createIndex("image_albums_sort", "image_albums", "sort")) {
            return false;
        }

        return true;
    }

    /**
     * Creates "image_instances" table
     *
     * @return bool
     */
    private function _createImageInstances()
    {
        $result = $this->createTable(
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
            ],
            "ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        if (!$result) {
            return false;
        }
        if (!$this->createIndex("image_instances_image_album_id", "image_instances", "image_album_id")) {
            return false;
        }
        if (!$this->createIndex("image_instances_is_cover", "image_instances", "is_cover")) {
            return false;
        }
        if (!$this->createIndex("image_instances_sort", "image_instances", "sort")) {
            return false;
        }

        return true;
    }
}