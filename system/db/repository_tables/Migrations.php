<?php

namespace system\db\repository_tables;

use system\db\Migration;

/**
 * Creates table for storing list of migrations
 *
 * @package system.db.repository_tables
 */
class Migrations extends Migration {

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"migrations",
			[
				"id"      => "pk",
				"version" => "string",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		return true;
	}
}