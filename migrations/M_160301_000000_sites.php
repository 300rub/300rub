<?php

namespace migrations;

use applications\App;
use components\Db;
use components\Language;

/**
 * Creates table for storing information about all sites
 *
 * @package migrations
 */
class M_160301_000000_sites extends AbstractMigration {

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
					"db_host"     => "string",
					"db_user"     => "string",
					"db_password" => "string",
					"db_name"     => "string",
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
			"INTO sites (host, db_host, db_user, db_password, db_name, language, email) " .
			"VALUES ('?', '?', '?', '?', '?', '?', '?')",
			[
				$config->host,
				$config->host,
				$config->db->user,
				$config->db->password,
				$config->db->name,
				array_search($config->language, Language::$aliasList),
				$config->email->adress
			]
		);
	}
}