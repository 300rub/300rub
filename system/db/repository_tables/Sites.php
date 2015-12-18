<?php

namespace system\db\repository_tables;

use system\App;
use system\web\Language;
use system\db\Db;
use system\db\Migration;

/**
 * Creates table for storing information about all sites
 *
 * @package system.db.repository_tables
 */
class Sites extends Migration {

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
		$host = App::console()->config->host;
		$dbHost = App::console()->config->db->host;
		$dbUser = App::console()->config->db->user;
		$dbPassword = App::console()->config->db->password;
		$dbName = App::console()->config->db->name;
		$language = array_search(App::console()->config->language, Language::$aliasList);
		$email = App::console()->config->email->adress;

		return Db::execute(
			"
			INSERT INTO sites
			(host, db_host, db_user, db_password, db_name, language, email)
			VALUES ('{$host}', '{$dbHost}', '{$dbUser}', '{$dbPassword}', '{$dbName}', '{$language}', '{$email}')
			"
		);
	}
}