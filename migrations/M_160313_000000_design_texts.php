<?php

namespace migrations;

/**
 * Creates design_texts table
 *
 * @package migrations
 */
class M_160313_000000_design_texts extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this->createTable(
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
			]
		);
	}
}