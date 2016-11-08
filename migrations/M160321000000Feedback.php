<?php

namespace testS\migrations;

/**
 * Creates feedback tables
 *
 * @package testS\migrations
 */
class M160321000000Feedback extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "feedbacks",
                [
                    "id"       => "pk",
                    "host"     => self::TYPE_STRING,
                    "port"     => self::TYPE_SMALLINT,
                    "type"     => self::TYPE_STRING,
                    "user"     => self::TYPE_STRING,
                    "password" => self::TYPE_STRING,
                ]
            );
    }
}