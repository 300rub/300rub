<?php

namespace ss\migrations\system;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing information about all sites
 */
class Sites extends AbstractMigration
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
                'sites',
                [
                    'id'         => self::TYPE_PK,
                    'name'       => self::TYPE_STRING,
                    'dbHost'     => self::TYPE_STRING,
                    'dbUser'     => self::TYPE_STRING,
                    'dbPassword' => self::TYPE_STRING,
                    'dbName'     => self::TYPE_STRING,
                    'language'   => self::TYPE_TINYINT_UNSIGNED,
                    'email'      => self::TYPE_STRING,
                    'isDisabled' => self::TYPE_BOOL,
                    'version'    => self::TYPE_INT_UNSIGNED,
                ]
            )
            ->createUniqueIndex('sites', 'sites_name', 'name');
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
    }
}
