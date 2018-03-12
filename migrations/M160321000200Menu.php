<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates records tables
 */
class M160321000200Menu extends AbstractMigration
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
                'designMenu',
                [
                    'id'                             => self::TYPE_PK,
                    'containerDesignBlockId'         => self::TYPE_FK,
                    'firstLevelDesignBlockId'        => self::TYPE_FK,
                    'firstLevelDesignTextId'         => self::TYPE_FK,
                    'firstLevelActiveDesignBlockId'  => self::TYPE_FK,
                    'firstLevelActiveDesignTextId'   => self::TYPE_FK,
                    'secondLevelDesignBlockId'       => self::TYPE_FK,
                    'secondLevelDesignTextId'        => self::TYPE_FK,
                    'secondLevelActiveDesignBlockId' => self::TYPE_FK,
                    'secondLevelActiveDesignTextId'  => self::TYPE_FK,
                    'lastLevelDesignBlockId'         => self::TYPE_FK,
                    'lastLevelDesignTextId'          => self::TYPE_FK,
                    'lastLevelActiveDesignBlockId'   => self::TYPE_FK,
                    'lastLevelActiveDesignTextId'    => self::TYPE_FK,
                ]
            )
            ->createForeignKey(
                'designMenu',
                'containerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'firstLevelDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'firstLevelDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designMenu',
                'firstLevelActiveDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'firstLevelActiveDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designMenu',
                'secondLevelDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'secondLevelDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designMenu',
                'secondLevelActiveDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'secondLevelActiveDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designMenu',
                'lastLevelDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'lastLevelDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designMenu',
                'lastLevelActiveDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designMenu',
                'lastLevelActiveDesignTextId',
                'designTexts'
            )
            ->createTable(
                'menu',
                [
                    'id'           => self::TYPE_PK,
                    'designMenuId' => self::TYPE_FK,
                    'type'         => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey('menu', 'designMenuId', 'designMenu')
            ->createTable(
                'menuInstances',
                [
                    'id'        => self::TYPE_PK,
                    'menuId'    => self::TYPE_FK,
                    'parentId'  => self::TYPE_FK_NULL,
                    'sectionId' => self::TYPE_FK,
                    'icon'      => self::TYPE_STRING_50,
                    'subName'   => self::TYPE_STRING,
                    'sort'      => self::TYPE_SMALLINT,
                ]
            )
            ->createForeignKey('menuInstances', 'menuId', 'menu')
            ->createForeignKey('menuInstances', 'parentId', 'menuInstances')
            ->createForeignKey('menuInstances', 'sectionId', 'sections');
    }
}
