<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates seo table
 */
class M160303000000Seo extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function up()
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
}
