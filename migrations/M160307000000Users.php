<?php

namespace testS\migrations;

/**
 * Creates users table
 *
 * @package testS\migrations
 */
class M160307000000Users extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "users",
                [
                    "id"       => self::TYPE_PK,
                    "login"    => self::TYPE_STRING_50,
                    "password" => self::TYPE_CHAR_40,
                ]
            )
            ->createIndex("users", "login");
    }
}