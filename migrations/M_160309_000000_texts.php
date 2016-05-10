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
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
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
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("texts_design_text_id", "texts", "design_text_id")) {
			return false;
		}

		if (!$this->createIndex("texts_design_block_id", "texts", "design_block_id")) {
			return false;
		}

		return true;
	}
}