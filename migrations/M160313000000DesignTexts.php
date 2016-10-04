<?php

namespace testS\migrations;

/**
 * Creates designTexts table
 *
 * @package migrations
 */
class M160313000000DesignTexts extends AbstractMigration
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