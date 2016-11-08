<?php

namespace testS\migrations;

use testS\applications\App;
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
                    "ssh"        => self::TYPE_STRING,
                ]
            )
            ->createIndex("sites", "host");
    }

    /**
     * Inserts test data
     */
    public function insertData()
    {
        $config = App::getApplication()->config;

        Db::execute(
            "INSERT " .
            "INTO sites (host, dbHost, dbUser, dbPassword, dbName, language, email, ssh) " .
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $config->host,
                $config->db->host,
                $config->db->user,
                $config->db->password,
                $config->db->name,
                $config->language,
                $config->email->address,
                $config->ssh->active
            ]
        );
    }
}