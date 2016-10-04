<?php

namespace testS\migrations;

use testS\applications\App;
use testS\components\Db;

/**
 * Creates table for storing information about all sites
 *
 * @package migrations
 */
class M160301000000Sites extends AbstractMigration {

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
					"id"          => "pk",
					"host"        => "string",
					"dbHost"     => "string",
					"dbUser"     => "string",
					"dbPassword" => "string",
					"dbName"     => "string",
					"language"    => "integer",
					"email"       => "string",
					"ssh"         => "string",
				]
			)
			->createIndex("sites_host", "sites", "host");
	}

	/**
	 * Inserts test data
	 */
	public function insertData()
	{
		$config = App::console()->config;

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