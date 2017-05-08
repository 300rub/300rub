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
                    "type"     => self::TYPE_TINYINT_UNSIGNED,
                    "password" => self::TYPE_CHAR_40,
                    "name"     => self::TYPE_STRING_100,
                    "email"    => self::TYPE_STRING_100,
                ]
            )
            ->createUniqueIndex("users", "users_login", "login")
            ->createUniqueIndex("users", "users_email", "email")
            ->createTable(
                "userSessions",
                [
                    "id"           => self::TYPE_PK,
                    "userId"       => self::TYPE_FK,
                    "token"        => self::TYPE_CHAR_32,
                    "ip"           => self::TYPE_STRING_25,
                    "ua"           => self::TYPE_STRING,
                    "lastActivity" => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey("userSessions", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createUniqueIndex("userSessions", "userSessions_token", "token")
            ->createTable(
                "userBlockOperations",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "blockId"   => self::TYPE_FK,
                    "blockType" => self::TYPE_TINYINT_UNSIGNED,
                    "operation" => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userBlockOperations", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("userBlockOperations", "blockId", "blocks", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userBlockGroupOperations",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "blockType" => self::TYPE_TINYINT_UNSIGNED,
                    "operation" => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userBlockGroupOperations", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userSectionOperations",
                [
                    "id"             => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "sectionId" => self::TYPE_FK,
                    "operation"      => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userSectionOperations", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("userSectionOperations", "sectionId", "sections", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userSectionGroupOperations",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "operation" => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userSectionGroupOperations", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userSettingsOperations",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "operation" => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userSettingsOperations", "userId", "users", self::FK_CASCADE, self::FK_CASCADE);
    }
}