<?php

namespace migrations;

/**
 * Creates table for storing list of migrations
 *
 * @package migrations
 */
class M_160302_000000_migrations extends AbstractMigration {

	/**
	 * Flag. If it is true - it will be skipped in common applying
	 *
	 * @var bool
	 */
	public $isSkip = true;

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