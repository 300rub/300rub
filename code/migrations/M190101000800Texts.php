<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates texts table
 */
class M190101000800Texts extends AbstractMigration
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
                'texts',
                [
                    'id'            => self::TYPE_PK,
                    'designTextId'  => self::TYPE_FK,
                    'designBlockId' => self::TYPE_FK,
                    'type'          => self::TYPE_TINYINT_UNSIGNED,
                    'hasEditor'     => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey('texts', 'designTextId', 'designTexts')
            ->createForeignKey('texts', 'designBlockId', 'designBlocks')
            ->createTable(
                'textInstances',
                [
                    'id'     => self::TYPE_PK,
                    'textId' => self::TYPE_FK,
                    'text'   => self::TYPE_TEXT,
                ]
            )
            ->createForeignKey(
                'textInstances',
                'textId',
                'texts',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createFullTextIndex('textInstances', 'text')
            ->createTable(
                'textInstanceFileMap',
                [
                    'id'             => self::TYPE_PK,
                    'textInstanceId' => self::TYPE_FK,
                    'fileId'         => self::TYPE_FK,
                ]
            )
            ->createForeignKey(
                'textInstanceFileMap',
                'textInstanceId',
                'textInstances',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'textInstanceFileMap',
                'fileId',
                'files',
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
            ->dropTable('textInstanceFileMap')
            ->dropTable('textInstances')
            ->dropTable('texts');
    }
}
