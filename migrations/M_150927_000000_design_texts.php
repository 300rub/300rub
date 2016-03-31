<?php

namespace migrations;

use system\db\Migration;

/**
 * Creates design_texts table
 *
 * @package migrations
 */
class M_150927_000000_design_texts extends Migration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"design_texts",
			[
				"id"             => "pk",
				"size"           => "integer",
				"family"         => "integer",
				"color"          => "string",
				"is_italic"      => "boolean",
				"is_bold"        => "boolean",
				"align"          => "integer",
				"decoration"     => "integer",
				"transform"      => "integer",
				"letter_spacing" => "integer",
				"line_height"    => "integer",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		return true;
	}
}