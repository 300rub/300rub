<?php

namespace migrations;

/**
 * Creates texts table
 *
 * @package migrations
 */
class M_160309_000000_texts extends AbstractMigration
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