<?php

namespace ss\migrations;

use ss\application\App;
use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing any help information
 */
class M160301000020Help extends AbstractMigration
{

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = true;

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->createTable(
                'categories',
                [
                    'id'          => self::TYPE_PK,
                    'parentId'    => self::TYPE_FK_NULL,
                    'language'    => self::TYPE_TINYINT,
                    'name'        => self::TYPE_STRING,
                    'text'        => self::TYPE_TEXT,
                    'alias'       => self::TYPE_STRING_50,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'categories',
                'parentId',
                'categories',
                self::FK_NULL,
                self::FK_NULL
            )
            ->createUniqueIndex(
                'categories',
                'categories_language_alias',
                'language,alias'
            )
            ->createTable(
                'pages',
                [
                    'id'          => self::TYPE_PK,
                    'categoryId'  => self::TYPE_FK_NULL,
                    'name'        => self::TYPE_STRING,
                    'text'        => self::TYPE_TEXT,
                    'alias'       => self::TYPE_STRING_50,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'pages',
                'categoryId',
                'categories'
            )
            ->createUniqueIndex(
                'pages',
                'pages_alias',
                'alias'
            );
    }
}
