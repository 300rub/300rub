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
                    "type"     => self::TYPE_TINYINT_UNSIGNED,
                    "name"     => self::TYPE_STRING_100,
                    "email"    => self::TYPE_STRING_100,
                ]
            )
            ->createIndex("users", "login")
            ->createTable(
                "userSessions",
                [
                    "id"       => self::TYPE_PK,
                    "userId"   => self::TYPE_FK,
                    "token"    => self::TYPE_CHAR_32,
                    "isActive" => self::TYPE_BOOL,
                    "ip"       => self::TYPE_STRING_25,
                    "ua"       => self::TYPE_STRING,
                    "date"     => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey("userSessions", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("userSessions", "isActive")
            ->createUniqueIndex("userSessions", "userSessions_token_isActive", "token,isActive")
            ->createTable(
                "userBlocks",
                [
                    "id"      => self::TYPE_PK,
                    "userId"  => self::TYPE_FK,
                    "blockId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("userBlocks", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("userBlocks", "blockId", "blocks", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userBlockOperations",
                [
                    "id"          => self::TYPE_PK,
                    "userBlockId" => self::TYPE_FK,
                    "operation"   => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey("userBlockOperations", "userBlockId", "userBlocks", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userBlockGroups",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "blockType" => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("userBlockGroups", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userBlockGroupOperations",
                [
                    "id"               => self::TYPE_PK,
                    "userBlockGroupId" => self::TYPE_FK,
                    "operation"        => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                "userBlockGroupOperations",
                "userBlockGroupId",
                "userBlockGroups",
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createTable(
                "userSections",
                [
                    "id"        => self::TYPE_PK,
                    "userId"    => self::TYPE_FK,
                    "sectionId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("userSections", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey("userSections", "sectionId", "sections", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userSectionOperations",
                [
                    "id"             => self::TYPE_PK,
                    "userSectionsId" => self::TYPE_FK,
                    "operation"      => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                "userSectionOperations",
                "userSectionsId",
                "userSections",
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createTable(
                "userSectionGroups",
                [
                    "id"     => self::TYPE_PK,
                    "userId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("userSectionGroups", "userId", "users", self::FK_CASCADE, self::FK_CASCADE)
            ->createTable(
                "userSectionGroupOperations",
                [
                    "id"                 => self::TYPE_PK,
                    "userSectionGroupId" => self::TYPE_FK,
                    "operation"          => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                "userSectionGroupOperations",
                "userSectionGroupId",
                "userSectionGroups",
                self::FK_CASCADE,
                self::FK_CASCADE
            )
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