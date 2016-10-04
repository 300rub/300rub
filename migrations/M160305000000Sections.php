<?php

namespace testS\migrations;

/**
 * Creates sections table
 *
 * @package testS\migrations
 */
class M160305000000Sections extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"sections",
				[
					"id"              => "pk",
					"seoId"          => "integer",
					"language"        => "integer",
					"width"           => "integer",
					"isMain"         => "boolean",
					"designBlockId" => "integer"
				]
			)
			->createIndex("sectionsSeoId", "sections", "seoId")
			->createIndex("sectionsLanguage", "sections", "language")
			->createIndex("sectionsIsMain", "sections", "isMain")
			->createIndex("sectionsDesignBlockId", "sections", "designBlockId");
	}
}