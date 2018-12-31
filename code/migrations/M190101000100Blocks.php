<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates blocks table
 */
class M190101000100Blocks extends AbstractMigration
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
                'blocks',
                [
                    'id'          => self::TYPE_PK,
                    'name'        => self::TYPE_STRING,
                    'language'    => self::TYPE_TINYINT_UNSIGNED,
                    'contentType' => self::TYPE_TINYINT_UNSIGNED,
                    'contentId'   => self::TYPE_FK
                ]
            )
            ->createIndex(
                'blocks',
                'language,contentType',
                'blocks_language_contentType'
            )
            ->createUniqueIndex(
                'blocks',
                'blocks_language_contentType_contentId',
                'language,contentType,contentId'
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('blocks');
    }
}
