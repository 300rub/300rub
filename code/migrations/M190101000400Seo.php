<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates seo table
 */
class M190101000400Seo extends AbstractMigration
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
                'seo',
                [
                    'id'          => self::TYPE_PK,
                    'name'        => self::TYPE_STRING,
                    'alias'       => self::TYPE_STRING,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createIndex('seo', 'name')
            ->createIndex('seo', 'alias');
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
        $this->dropTable('seo');
    }
}
