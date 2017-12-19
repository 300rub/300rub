<?php

namespace testS\migrations;

use testS\migrations\_abstract\AbstractMigration;

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
    public function apply()
    {
        $this
            ->createTable(
                'seo',
                [
                    'id'          => self::TYPE_PK,
                    'name'        => self::TYPE_STRING,
                    'url'         => self::TYPE_STRING,
                    'title'       => self::TYPE_STRING_100,
                    'keywords'    => self::TYPE_STRING,
                    'description' => self::TYPE_STRING,
                ]
            )
            ->createIndex('seo', 'name')
            ->createIndex('seo', 'url');
    }
}
