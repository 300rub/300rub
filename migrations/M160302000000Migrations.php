<?php

namespace testS\migrations;

/**
 * Creates table for storing list of migrations
 *
 * @package testS\migrations
 */
class M160302000000Migrations extends AbstractMigration
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
        $this->createTable(
            "migrations",
            [
                "id"      => "pk",
                "version" => "string",
            ]
        );
    }
}