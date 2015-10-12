<?php

namespace migrations;

use models\DesignBlockModel;
use system\db\Migration;

/**
 * @package migrations
 */
class M_151012_000000_design_blocks extends Migration
{

	/**
	 * Применяет миграцию
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
				"background_color"           => "string",
				"background"                 => "string",
				"gradient_direction"         => "integer",
				"border_top_color"           => "string",
				"border_top_width"           => "integer",
				"border_top_style"           => "integer",
				"border_top_left_radius"     => "integer",
				"border_right_color"         => "string",
				"border_right_width"         => "integer",
				"border_right_style"         => "integer",
				"border_top_right_radius"    => "integer",
				"border_bottom_color"        => "string",
				"border_bottom_width"        => "integer",
				"border_bottom_style"        => "integer",
				"border_bottom_right_radius" => "integer",
				"border_left_color"          => "string",
				"border_left_width"          => "integer",
				"border_left_style"          => "integer",
				"border_bottom_left_radius"  => "integer",
			],
			"ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"
		);
		if (!$result) {
			return false;
		}

		return true;
	}

	/**
	 * Добавляет тестовую информацию
	 *
	 * @return bool
	 */
	public function insertData()
	{
		$attributes = [
			"t.margin_top" => 20,
		];
		$model = new DesignBlockModel();
		$model->setAttributes($attributes);
		if (!$model->save()) {
			return false;
		}

		return true;
	}
}