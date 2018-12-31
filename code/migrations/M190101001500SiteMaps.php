<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates records tables
 */
class M190101001500SiteMaps extends AbstractMigration
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

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('siteMaps');
    }
}
