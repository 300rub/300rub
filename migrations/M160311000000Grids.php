<?php

namespace testS\migrations;

use testS\migrations\_abstract\AbstractMigration;

/**
 * Creates gridLines & grids tables
 */
class M160311000000Grids extends AbstractMigration
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
                'gridLines',
                [
                    'id'              => self::TYPE_PK,
                    'sectionId'       => self::TYPE_FK,
                    'outsideDesignId' => self::TYPE_FK,
                    'insideDesignId'  => self::TYPE_FK,
                    'sort'            => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey(
                'gridLines',
                'sectionId',
                'sections',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey('gridLines', 'outsideDesignId', 'designBlocks')
            ->createForeignKey('gridLines', 'insideDesignId', 'designBlocks')
            ->createIndex('gridLines', 'sort')
            ->createTable(
                'grids',
                [
                    'id'          => self::TYPE_PK,
                    'gridLineId'  => self::TYPE_FK,
                    'blockId'     => self::TYPE_FK,
                    'x'           => self::TYPE_TINYINT_UNSIGNED,
                    'y'           => self::TYPE_TINYINT_UNSIGNED,
                    'width'       => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey(
                'grids',
                'gridLineId',
                'gridLines',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'grids',
                'blockId',
                'blocks',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }
}
