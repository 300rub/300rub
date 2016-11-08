<?php

namespace testS\migrations;

/**
 * Creates seo table
 *
 * @package testS\migrations
 */
class M160303000000Seo extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "seo",
                [
                    "id"          => self::TYPE_PK,
                    "name"        => self::TYPE_STRING,
                    "url"         => self::TYPE_STRING,
                    "title"       => self::TYPE_STRING_100,
                    "keywords"    => self::TYPE_STRING,
                    "description" => self::TYPE_STRING,
                ]
            )
            ->createIndex("seo", "name")
            ->createIndex("seo", "url");
    }
}