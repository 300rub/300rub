<?php

namespace migrations;

/**
 * Creates seo table
 *
 * @package migrations
 */
class M160303000000Seo extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"seo",
				[
					"id"          => "pk",
					"name"        => "string",
					"url"         => "string",
					"title"       => "varchar(100) NOT NULL",
					"keywords"    => "string",
					"description" => "string",
				]
			)
			->createIndex("seoUrl", "seo", "url");
	}
}