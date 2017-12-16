<?php

namespace testS\migrations;

use testS\application\App;
use testS\components\Db;

/**
 * Creates table for storing information about all sites
 *
 * @package testS\migrations
 */
class M160301000000Sites extends AbstractMigration
{

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var bool
     */
    public $isSkip = true;

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "sites",
                [
                    "id"         => self::TYPE_PK,
                    "host"       => self::TYPE_STRING,
                    "dbHost"     => self::TYPE_STRING,
                    "dbUser"     => self::TYPE_STRING,
                    "dbPassword" => self::TYPE_STRING,
                    "dbName"     => self::TYPE_STRING,
                    "language"   => self::TYPE_TINYINT_UNSIGNED,
                    "email"      => self::TYPE_STRING,
                ]
            )
            ->createUniqueIndex("sites", "sites_host", "host");
    }

    /**
     * Inserts test data
     */
    public function insertData()
    {
        $app = App::getInstance();

        Db::execute(
            "INSERT " .
            "INTO sites (host, dbHost, dbUser, dbPassword, dbName, language, email) " .
            "VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                DEV_HOST,
                $app->getConfig(["db", "localhost", "host"]),
                $app->getConfig(["db", "localhost", "user"]),
                $app->getConfig(["db", "localhost", "password"]),
                $app->getConfig(["db", "localhost", "name"]),
                DEV_LANGUAGE,
                DEV_EMAIL,
            ]
        );
    }
}