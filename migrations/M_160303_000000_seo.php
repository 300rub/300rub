<?php

namespace migrations;

/**
 * Creates seo table
 *
 * @package migrations
 */
class M_160303_000000_seo extends AbstractMigration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"seo",
			[
				"id"          => "pk",
				"name"        => "string",
				"url"         => "string",
				"title"       => "varchar(100) NOT NULL",
				"keywords"    => "string",
				"description" => "string",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("seo_url", "seo", "url")) {
			return false;
		}

		return true;
	}
}