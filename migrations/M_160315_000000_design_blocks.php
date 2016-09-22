<?php

namespace migrations;

/**
 * Creates designBlocks table
 *
 * @package migrations
 */
class M_160315_000000_designBlocks extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this->createTable(
			"designBlocks",
			[
				"id"                         => "pk",
				"marginTop"                 => "integer",
				"marginRight"               => "integer",
				"marginBottom"              => "integer",
				"marginLeft"                => "integer",
				"paddingTop"                => "integer",
				"paddingRight"              => "integer",
				"paddingBottom"             => "integer",
				"paddingLeft"               => "integer",
				"backgroundColorFrom"      => "string",
				"backgroundColorTo"        => "string",
				"gradientDirection"         => "integer",
				"borderTopLeftRadius"     => "integer",
				"borderTopRightRadius"    => "integer",
				"borderBottomRightRadius" => "integer",
				"borderBottomLeftRadius"  => "integer",
				"borderTopWidth"           => "integer",
				"borderRightWidth"         => "integer",
				"borderBottomWidth"        => "integer",
				"borderLeftWidth"          => "integer",
				"borderStyle"               => "integer",
				"borderColor"               => "string",
			]
		);
	}
}