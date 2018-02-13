<?php

namespace ss\migrations;

use ss\application\App;
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
    public function apply()
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
                ]
            )
            ->createUniqueIndex('sites', 'sites_name', 'name');
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
            '(name, dbHost, dbUser, dbPassword, dbName, language, email)' .
            ' VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                'site1',
                $config->getValue(['db', 'site1', 'host']),
                $config->getValue(['db', 'site1', 'user']),
                $config->getValue(['db', 'site1', 'password']),
                $config->getValue(['db', 'site1', 'name']),
                DEV_LANGUAGE,
                DEV_EMAIL,
            ]
        );

        $dbObject->execute(
            'INSERT ' .
            'INTO sites ' .
            '(name, dbHost, dbUser, dbPassword, dbName, language, email)' .
            ' VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                'site2',
                $config->getValue(['db', 'site2', 'host']),
                $config->getValue(['db', 'site2', 'user']),
                $config->getValue(['db', 'site2', 'password']),
                $config->getValue(['db', 'site2', 'name']),
                DEV_LANGUAGE,
                DEV_EMAIL,
            ]
        );
    }
}
