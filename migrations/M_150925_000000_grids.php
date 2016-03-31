<?php

namespace migrations;

use system\db\Migration;

/**
 * Creates grid_lines & grids tables
 *
 * @package migrations
 */
class M_150925_000000_grids extends Migration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"grid_lines",
			[
				"id"                => "pk",
				"section_id"        => "integer",
				"sort"              => "integer",
				"outside_design_id" => "integer",
				"inside_design_id"  => "integer"
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("grid_lines_section_id", "grid_lines", "section_id")) {
			return false;
		}
		if (!$this->createIndex("grid_lines_sort", "grid_lines", "sort")) {
			return false;
		}
		if (!$this->createIndex("grid_lines_outside_design_id", "grid_lines", "outside_design_id")) {
			return false;
		}
		if (!$this->createIndex("grid_lines_inside_design_id", "grid_lines", "inside_design_id")) {
			return false;
		}

		$result = $this->createTable(
			"grids",
			[
				"id"           => "pk",
				"grid_line_id" => "integer",
				"content_type" => "integer",
				"content_id"   => "integer",
				"x"            => "integer",
				"y"            => "integer",
				"width"        => "integer"
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		if (!$this->createIndex("grids_grid_line_id", "grids", "grid_line_id")) {
			return false;
		}

		return true;
	}
}