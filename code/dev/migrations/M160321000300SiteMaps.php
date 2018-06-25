<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates records tables
 */
class M160321000300SiteMaps extends AbstractMigration
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
                'siteMaps',
                [
                    'id'                     => self::TYPE_PK,
                    'containerDesignBlockId' => self::TYPE_FK,
                    'itemDesignBlockId'      => self::TYPE_FK,
                    'itemDesignTextId'       => self::TYPE_FK,
                    'style'                  => self::TYPE_TINYINT_UNSIGNED
                ]
            )
            ->createForeignKey(
                'siteMaps',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'siteMaps',
                'itemDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'siteMaps',
                'itemDesignTextId',
                'designTexts'
            );
    }
}
