<?php

namespace migrations;

/**
 * Creates sections table
 *
 * @package migrations
 */
class M_160305_000000_sections extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"sections",
				[
					"id"              => "pk",
					"seoId"          => "integer",
					"language"        => "integer",
					"width"           => "integer",
					"isMain"         => "boolean",
					"design_block_id" => "integer"
				]
			)
			->createIndex("sections_seoId", "sections", "seoId")
			->createIndex("sections_language", "sections", "language")
			->createIndex("sections_isMain", "sections", "isMain")
			->createIndex("sections_design_block_id", "sections", "design_block_id");
	}
}