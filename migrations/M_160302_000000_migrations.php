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