<?php

namespace testS\migrations;

/**
 * Creates search tables
 *
 * @package testS\migrations
 */
class M160321000400Search extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designSearch",
                [
                    "id"                          => self::TYPE_PK,
                    "designBlockId"        => self::TYPE_FK,
                    "titleDesignBlockId"          => self::TYPE_FK,
                    "titleDesignTextId"           => self::TYPE_FK,
                    "descriptionDesignBlockId"    => self::TYPE_FK,
                    "descriptionDesignTextId"     => self::TYPE_FK,
                    "paginationDesignBlockId"     => self::TYPE_FK,
                    "paginationItemDesignBlockId" => self::TYPE_FK,
                    "paginationItemDesignTextId"  => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designSearch", "designBlockId", "designBlocks")
            ->createForeignKey("designSearch", "titleDesignBlockId", "designBlocks")
            ->createForeignKey("designSearch", "titleDesignTextId", "designTexts")
            ->createForeignKey("designSearch", "descriptionDesignBlockId", "designBlocks")
            ->createForeignKey("designSearch", "descriptionDesignTextId", "designTexts")
            ->createForeignKey("designSearch", "paginationDesignBlockId", "designBlocks")
            ->createForeignKey("designSearch", "paginationItemDesignBlockId", "designBlocks")
            ->createForeignKey("designSearch", "paginationItemDesignTextId", "designTexts")
            ->createTable(
                "search",
                [
                    "id"             => self::TYPE_PK,
                    "formId"         => self::TYPE_FK,
                    "searchDesignId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("search", "formId", "forms")
            ->createForeignKey("search", "searchDesignId", "designSearch")
            ->createTable(
                "searchQueries",
                [
                    "id"         => self::TYPE_PK,
                    "searchId"   => self::TYPE_FK,
                    "text"       => self::TYPE_STRING,
                    "date"       => self::TYPE_DATETIME,
                    "ip"         => self::TYPE_STRING_25,
                    "ua"         => self::TYPE_STRING,
                    "port"       => self::TYPE_TINYINT_UNSIGNED,
                    "connection" => self::TYPE_STRING,
                    "host"       => self::TYPE_STRING,
                    "ref"        => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("searchQueries", "searchId", "search");
    }
}