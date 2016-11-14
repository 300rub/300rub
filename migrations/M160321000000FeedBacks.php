<?php

namespace testS\migrations;

/**
 * Creates feedback tables
 *
 * @package testS\migrations
 */
class M160321000000FeedBacks extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "feedBacks",
                [
                    "id"                   => self::TYPE_PK,
                    "formId"               => self::TYPE_FK,
                    "subjectFormElementId" => self::TYPE_FK_NULL,
                    "subjectText"          => self::TYPE_STRING,
                    "host"                 => self::TYPE_STRING,
                    "port"                 => self::TYPE_SMALLINT_UNSIGNED,
                    "type"                 => self::TYPE_STRING,
                    "user"                 => self::TYPE_STRING,
                    "password"             => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("feedBacks", "formId", "forms")
            ->createForeignKey("feedBacks", "subjectFormElementId", "formElements");
    }
}