<?php

namespace migrations;

use system\db\Migration;

/**
 * Creates sections table
 *
 * @package migrations
 */
class M_150101_020202_sections extends Migration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"sections",
			[
				"id"              => "pk",
				"seo_id"          => "integer",
				"language"        => "integer",
				"width"           => "integer",
				"is_main"         => "boolean",
				"design_block_id" => "integer"
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("sections_seo_id", "sections", "seo_id")) {
			return false;
		}

		if (!$this->createIndex("sections_language", "sections", "language")) {
			return false;
		}

		if (!$this->createIndex("sections_is_main", "sections", "is_main")) {
			return false;
		}

		if (!$this->createIndex("sections_design_block_id", "sections", "design_block_id")) {
			return false;
		}

		return true;
	}
}