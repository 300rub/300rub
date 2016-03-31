<?php

namespace migrations;

/**
 * Creates design_blocks table
 *
 * @package migrations
 */
class M_160315_000000_design_blocks extends AbstractMigration
{

	/**
	 * Applies migration
	 *
	 * @return bool
	 */
	public function up()
	{
		$result = $this->createTable(
			"design_blocks",
			[
				"id"                         => "pk",
				"margin_top"                 => "integer",
				"margin_right"               => "integer",
				"margin_bottom"              => "integer",
				"margin_left"                => "integer",
				"padding_top"                => "integer",
				"padding_right"              => "integer",
				"padding_bottom"             => "integer",
				"padding_left"               => "integer",
				"background_color_from"      => "string",
				"background_color_to"        => "string",
				"gradient_direction"         => "integer",
				"border_top_left_radius"     => "integer",
				"border_top_right_radius"    => "integer",
				"border_bottom_right_radius" => "integer",
				"border_bottom_left_radius"  => "integer",
				"border_top_width"           => "integer",
				"border_right_width"         => "integer",
				"border_bottom_width"        => "integer",
				"border_left_width"          => "integer",
				"border_style"               => "integer",
				"border_color"               => "string",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		return true;
	}
}