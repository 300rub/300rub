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
	 */
	public function up()
	{
		$this
			->createTable(
				"users",
				[
					"id"       => "pk",
					"login"    => "string",
					"password" => "char(40) not null",
				]
			)
			->createIndex("usersLogin", "users", "login");
	}
}