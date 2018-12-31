<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates sections table
 */
class M190101000500Sections extends AbstractMigration
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
                'sections',
                [
                    'id'            => self::TYPE_PK,
                    'seoId'         => self::TYPE_FK,
                    'designBlockId' => self::TYPE_FK,
                    'language'      => self::TYPE_TINYINT_UNSIGNED,
                    'padding'       => self::TYPE_INT_UNSIGNED,
                    'isMain'        => self::TYPE_BOOL,
                    'isPublished'   => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey('sections', 'seoId', 'seo')
            ->createForeignKey('sections', 'designBlockId', 'designBlocks')
            ->createIndex(
                'sections',
                'language,isMain,isPublished',
                'sections_language_isMain_isPublished'
            )
            ->createIndex(
                'sections',
                'language,isPublished',
                'sections_language_isPublished'
            )
            ->createIndex(
                'sections',
                'language'
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('sections');
    }
}
