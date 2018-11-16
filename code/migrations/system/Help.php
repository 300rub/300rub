<?php

namespace ss\migrations\system;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing any help information
 */
class Help extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    protected function up()
    {
        $this
            ->createTable(
                'categories',
                [
                    'id'          => self::TYPE_PK,
                    'parentId'    => self::TYPE_FK_NULL,
                    'alias'       => self::TYPE_STRING_50,
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
                'categories_alias',
                'alias'
            )
            ->createTable(
                'languageCategories',
                [
                    'id'          => self::TYPE_PK,
                    'categoryId'  => self::TYPE_FK,
                    'language'    => self::TYPE_TINYINT,
                    'name'        => self::TYPE_STRING,
                    'text'        => self::TYPE_TEXT,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createIndex(
                'languageCategories',
                'name'
            )
            ->createForeignKey(
                'languageCategories',
                'categoryId',
                'categories'
            )
            ->createUniqueIndex(
                'languageCategories',
                'languageCategories_categoryId_language',
                'categoryId,language'
            )
            ->createTable(
                'pages',
                [
                    'id'          => self::TYPE_PK,
                    'categoryId'  => self::TYPE_FK,
                    'alias'       => self::TYPE_STRING_50,
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
            )
            ->createTable(
                'languagePages',
                [
                    'id'          => self::TYPE_PK,
                    'pageId'      => self::TYPE_FK,
                    'language'    => self::TYPE_TINYINT,
                    'name'        => self::TYPE_STRING,
                    'text'        => self::TYPE_TEXT,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'languagePages',
                'pageId',
                'pages'
            )
            ->createUniqueIndex(
                'languagePages',
                'languagePages_pageId_language',
                'pageId,language'
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
    }
}
