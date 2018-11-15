<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing information about all sites
 */
class M160301000000Sites extends AbstractMigration
{

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = true;

    /**
     * Applies migration
     *
     * @return void
     */
    public function up()
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
                    'isSource'   => self::TYPE_BOOL,
                    'version'    => self::TYPE_INT_UNSIGNED,
                ]
            )
            ->createUniqueIndex('sites', 'sites_name', 'name');
    }
}
