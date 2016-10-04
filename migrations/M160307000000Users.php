<?php

namespace testS\migrations;

/**
 * Creates users table
 *
 * @package testS\migrations
 */
class M160307000000Users extends AbstractMigration
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