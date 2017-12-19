<?php

namespace testS\migrations;

use testS\application\App;
use testS\migrations\_abstract\AbstractMigration;

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
    public function apply()
    {
        $this
            ->createTable(
                'sites',
                [
                    'id'         => self::TYPE_PK,
                    'host'       => self::TYPE_STRING,
                    'dbHost'     => self::TYPE_STRING,
                    'dbUser'     => self::TYPE_STRING,
                    'dbPassword' => self::TYPE_STRING,
                    'dbName'     => self::TYPE_STRING,
                    'language'   => self::TYPE_TINYINT_UNSIGNED,
                    'email'      => self::TYPE_STRING,
                ]
            )
            ->createUniqueIndex('sites', 'sites_host', 'host');
    }

    /**
     * Inserts test data
     *
     * @return void
     */
    public function insertData()
    {
        $dbObject = App::getInstance()->getDb();
        $config = App::getInstance()->getConfig();

        $dbObject->execute(
            'INSERT ' .
            'INTO sites ' .
            '(host, dbHost, dbUser, dbPassword, dbName, language, email)' .
            ' VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                DEV_HOST,
                $config->getValue(['db', 'localhost', 'host']),
                $config->getValue(['db', 'localhost', 'user']),
                $config->getValue(['db', 'localhost', 'password']),
                $config->getValue(['db', 'localhost', 'name']),
                DEV_LANGUAGE,
                DEV_EMAIL,
            ]
        );
    }
}
