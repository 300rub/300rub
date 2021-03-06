<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates search tables
 */
class M190101001600Search extends AbstractMigration
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
                'designSearch',
                [
                    'id'                          => self::TYPE_PK,
                    'containerDesignBlockId'      => self::TYPE_FK,
                    'titleDesignBlockId'          => self::TYPE_FK,
                    'titleDesignTextId'           => self::TYPE_FK,
                    'descriptionDesignBlockId'    => self::TYPE_FK,
                    'descriptionDesignTextId'     => self::TYPE_FK,
                    'paginationDesignBlockId'     => self::TYPE_FK,
                    'paginationItemDesignBlockId' => self::TYPE_FK,
                    'paginationItemDesignTextId'  => self::TYPE_FK,
                ]
            )
            ->createForeignKey(
                'designSearch',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designSearch',
                'titleDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designSearch',
                'titleDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designSearch',
                'descriptionDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designSearch',
                'descriptionDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designSearch',
                'paginationDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designSearch',
                'paginationItemDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designSearch',
                'paginationItemDesignTextId',
                'designTexts'
            )
            ->createTable(
                'search',
                [
                    'id'             => self::TYPE_PK,
                    'formId'         => self::TYPE_FK,
                    'searchDesignId' => self::TYPE_FK,
                ]
            )
            ->createForeignKey('search', 'formId', 'forms')
            ->createForeignKey('search', 'searchDesignId', 'designSearch')
            ->createTable(
                'searchQueries',
                [
                    'id'       => self::TYPE_PK,
                    'searchId' => self::TYPE_FK,
                    'text'     => self::TYPE_STRING,
                    'date'     => self::TYPE_DATETIME,
                    'ip'       => self::TYPE_STRING_25,
                    'ua'       => self::TYPE_STRING,
                    'uri'      => self::TYPE_STRING,
                    'ref'      => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'searchQueries',
                'searchId',
                'search',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this
            ->dropTable('searchQueries')
            ->dropTable('search')
            ->dropTable('designSearch');
    }
}
