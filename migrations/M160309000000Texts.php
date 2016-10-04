<?php

namespace testS\migrations;

/**
 * Creates texts table
 *
 * @package testS\migrations
 */
class M160309000000Texts extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"texts",
				[
					"id"              => "pk",
					"name"            => "string",
					"language"        => "integer",
					"type"            => "integer",
					"isEditor"       => "boolean",
					"text"            => "text",
					"designTextId"  => "integer",
					"designBlockId" => "integer",
				]
			)
			->createIndex("textsDesignTextId", "texts", "designTextId")
			->createIndex("textsDesignBlockId", "texts", "designBlockId");
	}
}