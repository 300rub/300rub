<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates sections table
 */
class M160305000000Sections extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->createTable(
                'sections',
                [
                    'id'            => self::TYPE_PK,
                    'seoId'         => self::TYPE_FK,
                    'designBlockId' => self::TYPE_FK,
                    'language'      => self::TYPE_TINYINT_UNSIGNED,
                    'isMain'        => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey('sections', 'seoId', 'seo')
            ->createForeignKey('sections', 'designBlockId', 'designBlocks')
            ->createIndex(
                'sections',
                'language,isMain',
                'sections_language_isMain'
            );
    }
}
