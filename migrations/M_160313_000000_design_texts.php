<?php

namespace migrations;

/**
 * Creates designTexts table
 *
 * @package migrations
 */
class M_160313_000000_designTexts extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this->createTable(
			"designTexts",
			[
				"id"             => "pk",
				"size"           => "integer",
				"family"         => "integer",
				"color"          => "string",
				"isItalic"      => "boolean",
				"isBold"        => "boolean",
				"align"          => "integer",
				"decoration"     => "integer",
				"transform"      => "integer",
				"letterSpacing" => "integer",
				"lineHeight"    => "integer",
			]
		);
	}
}