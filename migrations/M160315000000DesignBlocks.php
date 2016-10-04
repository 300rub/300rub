<?php

namespace testS\migrations;

/**
 * Creates designBlocks table
 *
 * @package migrations
 */
class M160315000000DesignBlocks extends AbstractMigration
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