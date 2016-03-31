<?php

namespace migrations;

use application\App;
use components\Db;
use components\Language;

/**
 * Creates table for storing information about all sites
 *
 * @package migrations
 */
class M_160301_000000_sites extends AbstractMigration {

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
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
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		$result = $this->createIndex("sites_host", "sites", "host");
		if (!$result) {
			return false;
		}

		return true;
	}

	/**
	 * Inserts test data
	 *
	 * @return bool
	 */
	public function insertData()
	{
		$config = App::console()->config;

		return Db::execute(
			"
			INSERT INTO sites
			(host, db_host, db_user, db_password, db_name, language, email)
			VALUES ('?', '?', '?', '?', '?', '?', '?')
			",
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