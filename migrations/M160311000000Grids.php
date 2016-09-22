<?php

namespace migrations;

/**
 * Creates gridLines & grids tables
 *
 * @package migrations
 */
class M160311000000Grids extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"gridLines",
				[
					"id"                => "pk",
					"sectionId"        => "integer",
					"sort"              => "integer",
					"outsideDesignId" => "integer",
					"insideDesignId"  => "integer"
				]
			)
			->createIndex("gridLinesSectionId", "gridLines", "sectionId")
			->createIndex("gridLinesSort", "gridLines", "sort")
			->createIndex("gridLinesOutsideDesignId", "gridLines", "outsideDesignId")
			->createIndex("gridLinesInsideDesignId", "gridLines", "insideDesignId")
			->createTable(
				"grids",
				[
					"id"           => "pk",
					"gridLineId" => "integer",
					"contentType" => "integer",
					"contentId"   => "integer",
					"x"            => "integer",
					"y"            => "integer",
					"width"        => "integer"
				]
			)
			->createIndex("gridsGridLineId", "grids", "gridLineId");
	}
}