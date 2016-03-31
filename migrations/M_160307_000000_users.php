<?php

namespace migrations;

/**
 * Creates users table
 *
 * @package migrations
 */
class M_160307_000000_users extends AbstractMigration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"users",
			[
				"id"       => "pk",
				"login"    => "string",
				"password" => "char(40) not null",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("users_login", "users", "login")) {
			return false;
		}

		return true;
	}
}