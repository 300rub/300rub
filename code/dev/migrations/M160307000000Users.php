<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates users table
 */
class M160307000000Users extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->_createUsers()
            ->_createUserSessions()
            ->_createUserBlockOperations()
            ->_createUserBlockGroupOperations()
            ->_createUserSectionOperations()
            ->_createUserSectionGroupOperations()
            ->_createUserSettingsOperations()
            ->_createUserActions();
    }

    /**
     * Creates users table
     *
     * @return M160307000000Users
     */
    private function _createUsers()
    {
        return $this
            ->createTable(
                'users',
                [
                    'id'       => self::TYPE_PK,
                    'login'    => self::TYPE_STRING_50,
                    'type'     => self::TYPE_TINYINT_UNSIGNED,
                    'password' => self::TYPE_CHAR_40,
                    'name'     => self::TYPE_STRING_100,
                    'email'    => self::TYPE_STRING_100,
                    'code'     => self::TYPE_STRING_25,
                ]
            )
            ->createUniqueIndex('users', 'users_login', 'login')
            ->createUniqueIndex('users', 'users_email', 'email');
    }

    /**
     * Creates userSessions table
     *
     * @return M160307000000Users
     */
    private function _createUserSessions()
    {
        return $this
            ->createTable(
                'userSessions',
                [
                    'id'           => self::TYPE_PK,
                    'userId'       => self::TYPE_FK,
                    'token'        => self::TYPE_CHAR_32,
                    'ip'           => self::TYPE_STRING_25,
                    'ua'           => self::TYPE_STRING,
                    'lastActivity' => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey(
                'userSessions',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createUniqueIndex(
                'userSessions',
                'userSessions_token',
                'token'
            );
    }

    /**
     * Creates userBlockOperations table
     *
     * @return M160307000000Users
     */
    private function _createUserBlockOperations()
    {
        return $this
            ->createTable(
                'userBlockOperations',
                [
                    'id'        => self::TYPE_PK,
                    'userId'    => self::TYPE_FK,
                    'blockId'   => self::TYPE_FK,
                    'blockType' => self::TYPE_TINYINT_UNSIGNED,
                    'operation' => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                'userBlockOperations',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'userBlockOperations',
                'blockId',
                'blocks',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates userBlockGroupOperations table
     *
     * @return M160307000000Users
     */
    private function _createUserBlockGroupOperations()
    {
        return $this
            ->createTable(
                'userBlockGroupOperations',
                [
                    'id'        => self::TYPE_PK,
                    'userId'    => self::TYPE_FK,
                    'blockType' => self::TYPE_TINYINT_UNSIGNED,
                    'operation' => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                'userBlockGroupOperations',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates table userSectionOperations
     *
     * @return M160307000000Users
     */
    private function _createUserSectionOperations()
    {
        return $this
            ->createTable(
                'userSectionOperations',
                [
                    'id'             => self::TYPE_PK,
                    'userId'    => self::TYPE_FK,
                    'sectionId' => self::TYPE_FK,
                    'operation'      => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                'userSectionOperations',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'userSectionOperations',
                'sectionId',
                'sections',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates userSectionGroupOperations table
     *
     * @return M160307000000Users
     */
    private function _createUserSectionGroupOperations()
    {
        return $this
            ->createTable(
                'userSectionGroupOperations',
                [
                    'id'        => self::TYPE_PK,
                    'userId'    => self::TYPE_FK,
                    'operation' => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                'userSectionGroupOperations',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates userSettingsOperations table
     *
     * @return M160307000000Users
     */
    private function _createUserSettingsOperations()
    {
        return $this
            ->createTable(
                'userSettingsOperations',
                [
                    'id'        => self::TYPE_PK,
                    'userId'    => self::TYPE_FK,
                    'operation' => self::TYPE_STRING_50,
                ]
            )
            ->createForeignKey(
                'userSettingsOperations',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Creates userSettingsOperations table
     *
     * @return M160307000000Users
     */
    private function _createUserActions()
    {
        return $this
            ->createTable(
                'userActions',
                [
                    'id'     => self::TYPE_PK,
                    'userId' => self::TYPE_FK,
                    'type'   => self::TYPE_TINYINT_UNSIGNED,
                    'name'   => self::TYPE_STRING,
                    'date'   => self::TYPE_DATETIME,
                ]
            )
            ->createForeignKey(
                'userActions',
                'userId',
                'users',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex(
                'userActions',
                'date'
            );
    }
}
