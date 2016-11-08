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
                    "id"              => self::TYPE_PK,
                    "sectionId"       => self::TYPE_INT,
                    "outsideDesignId" => self::TYPE_INT,
                    "insideDesignId"  => self::TYPE_INT,
                    "sort"            => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey("gridLines", "sectionId", "sections", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("gridLines", "outsideDesignId", "designBlocks")
            ->createForeignKey("gridLines", "insideDesignId", "designBlocks")
            ->createIndex("gridLines", "sort")
            ->createTable(
                "grids",
                [
                    "id"          => self::TYPE_PK,
                    "gridLineId"  => self::TYPE_INT,
                    "contentType" => self::TYPE_INT,
                    "contentId"   => self::TYPE_INT,
                    "x"           => self::TYPE_TINYINT,
                    "y"           => self::TYPE_TINYINT,
                    "width"       => self::TYPE_TINYINT,
                ]
            )
            ->createForeignKey("grids", "gridLineId", "gridLines", self::FK_CASCADE, self::FK_CASCADE);
    }
}