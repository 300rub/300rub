<?php

namespace migrations;

/**
 * Creates grid_lines & grids tables
 *
 * @package migrations
 */
class M_160311_000000_grids extends AbstractMigration
{

	/**
	 * Applies migration
	 */
	public function up()
	{
		$this
			->createTable(
				"grid_lines",
				[
					"id"                => "pk",
					"section_id"        => "integer",
					"sort"              => "integer",
					"outside_design_id" => "integer",
					"inside_design_id"  => "integer"
				]
			)
			->createIndex("grid_lines_section_id", "grid_lines", "section_id")
			->createIndex("grid_lines_sort", "grid_lines", "sort")
			->createIndex("grid_lines_outside_design_id", "grid_lines", "outside_design_id")
			->createIndex("grid_lines_inside_design_id", "grid_lines", "inside_design_id")
			->createTable(
				"grids",
				[
					"id"           => "pk",
					"grid_line_id" => "integer",
					"content_type" => "integer",
					"content_id"   => "integer",
					"x"            => "integer",
					"y"            => "integer",
					"width"        => "integer"
				]
			)
			->createIndex("grids_grid_line_id", "grids", "grid_line_id");
	}
}