<?php

namespace testS\migrations;

/**
 * Creates gridLines & grids tables
 *
 * @package testS\migrations
 */
class M160311000000Grids extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "gridLines",
                [
                    "id"              => "pk",
                    "sectionId"       => "integer",
                    "sort"            => "integer",
                    "outsideDesignId" => "integer",
                    "insideDesignId"  => "integer"
                ]
            )
            ->createForeignKey("gridLines", "sectionId", "sections", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("gridLines", "sort")
            ->createForeignKey("gridLines", "outsideDesignId", "designBlocks")
            ->createForeignKey("gridLines", "insideDesignId", "designBlocks")
            ->createTable(
                "grids",
                [
                    "id"          => "pk",
                    "gridLineId"  => "integer",
                    "contentType" => "integer",
                    "contentId"   => "integer",
                    "x"           => "integer",
                    "y"           => "integer",
                    "width"       => "integer"
                ]
            )
            ->createForeignKey("grids", "gridLineId", "gridLines", self::FK_CASCADE, self::FK_CASCADE);
    }
}