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
					"seo_id"          => "integer",
					"language"        => "integer",
					"width"           => "integer",
					"is_main"         => "boolean",
					"design_block_id" => "integer"
				]
			)
			->createIndex("sections_seo_id", "sections", "seo_id")
			->createIndex("sections_language", "sections", "language")
			->createIndex("sections_is_main", "sections", "is_main")
			->createIndex("sections_design_block_id", "sections", "design_block_id");
	}
}