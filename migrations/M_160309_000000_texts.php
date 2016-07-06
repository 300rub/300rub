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
					"is_editor"       => "boolean",
					"text"            => "text",
					"design_text_id"  => "integer",
					"design_block_id" => "integer",
				]
			)
			->createIndex("texts_design_text_id", "texts", "design_text_id")
			->createIndex("texts_design_block_id", "texts", "design_block_id");
	}
}