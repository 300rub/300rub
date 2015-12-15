<?php

namespace models;

use system\base\Model;

/**
 * Model for working with table "design_block"
 *
 * @package models
 */
class DesignBlockModel extends Model
{

	/**
	 * Gradient direction. Horizontal
	 */
	const GRADIENT_DIRECTION_HORIZONTAL = 0;

	/**
	 * Gradient direction. Vertical
	 */
	const GRADIENT_DIRECTION_VERTICAL = 1;

	/**
	 * Gradient direction. 135 DEG
	 */
	const GRADIENT_DIRECTION_135DEG = 2;

	/**
	 * Gradient direction. 45 DEG
	 */
	const GRADIENT_DIRECTION_45DEG = 3;

	/**
	 * Border style. None
	 */
	const BORDER_STYLE_NONE = 0;

	/**
	 * Border style. Solid
	 */
	const BORDER_STYLE_SOLID = 1;

	/**
	 * Border style. Dotted
	 */
	const BORDER_STYLE_DOTTED = 2;

	/**
	 * Border style. Dashed
	 */
	const BORDER_STYLE_DASHED = 3;

	/**
	 * margin-top
	 *
	 * @var int
	 */
	public $margin_top;

	/**
	 * margin-right
	 *
	 * @var int
	 */
	public $margin_right;

	/**
	 * margin-bottom
	 *
	 * @var int
	 */
	public $margin_bottom;

	/**
	 * margin-left
	 *
	 * @var int
	 */
	public $margin_left;

	/**
	 * padding-top
	 *
	 * @var int
	 */
	public $padding_top;

	/**
	 * padding-right
	 *
	 * @var int
	 */
	public $padding_right;

	/**
	 * padding-bottom
	 *
	 * @var int
	 */
	public $padding_bottom;

	/**
	 * padding-left
	 *
	 * @var int
	 */
	public $padding_left;

	/**
	 * background-color (from)
	 * used in gradient or simple background-color
	 *
	 * @var string
	 */
	public $background_color_from;

	/**
	 * background-color (to)
	 * used in gradient or simple background-color
	 *
	 * @var string
	 */
	public $background_color_to;

	/**
	 * Gradient direction
	 *
	 * @var int
	 */
	public $gradient_direction;

	/**
	 * border-top-width
	 *
	 * @var int
	 */
	public $border_top_width;

	/**
	 * border-top-left-radius
	 *
	 * @var int
	 */
	public $border_top_left_radius;

	/**
	 * border-right-width
	 *
	 * @var int
	 */
	public $border_right_width;

	/**
	 * border-top-right-radius
	 *
	 * @var int
	 */
	public $border_top_right_radius;

	/**
	 * border-bottom-width
	 *
	 * @var int
	 */
	public $border_bottom_width;

	/**
	 * border-bottom-right-radius
	 *
	 * @var int
	 */
	public $border_bottom_right_radius;

	/**
	 * border-left-width
	 *
	 * @var int
	 */
	public $border_left_width;

	/**
	 * border-bottom-left-radius
	 *
	 * @var int
	 */
	public $border_bottom_left_radius;

	/**
	 * border-color
	 *
	 * @var string
	 */
	public $border_color;

	/**
	 * border-style
	 *
	 * @var int
	 */
	public $border_style;

	/**
	 * List of gradient directions options
	 *
	 * @var array
	 */
	public static $gradientDirectionList = [
		self::GRADIENT_DIRECTION_HORIZONTAL => [
			"mozLinear"    => "left",
			"webkit"       => "linear, left top, right top",
			"webkitLinear" => "left",
			"oLinear"      => "left",
			"msLinear"     => "left",
			"linear"       => "to right",
			"ie"           => 1,
			"label"        => "→"
		],
		self::GRADIENT_DIRECTION_VERTICAL   => [
			"mozLinear"    => "top",
			"webkit"       => "linear, left top, left bottom",
			"webkitLinear" => "top",
			"oLinear"      => "top",
			"msLinear"     => "top",
			"linear"       => "to bottom",
			"ie"           => 0,
			"label"        => "↓"
		],
		self::GRADIENT_DIRECTION_135DEG     => [
			"mozLinear"    => "-45deg",
			"webkit"       => "linear, left top, right bottom",
			"webkitLinear" => "-45deg",
			"oLinear"      => "-45deg",
			"msLinear"     => "-45deg",
			"linear"       => "135deg",
			"ie"           => 1,
			"label"        => "↘"
		],
		self::GRADIENT_DIRECTION_45DEG      => [
			"mozLinear"    => "45deg",
			"webkit"       => "linear, left bottom, right top",
			"webkitLinear" => "45deg",
			"oLinear"      => "45deg",
			"msLinear"     => "45deg",
			"linear"       => "45deg",
			"ie"           => 1,
			"label"        => "↗"
		],
	];

	/**
	 * List of border styles
	 *
	 * @var array
	 */
	public static $borderStyleList = [
		self::BORDER_STYLE_NONE   => "none",
		self::BORDER_STYLE_SOLID  => "solid",
		self::BORDER_STYLE_DOTTED => "dotted",
		self::BORDER_STYLE_DASHED => "dashed",
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "design_blocks";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"margin_top"                 => [],
			"margin_right"               => [],
			"margin_bottom"              => [],
			"margin_left"                => [],
			"padding_top"                => [],
			"padding_right"              => [],
			"padding_bottom"             => [],
			"padding_left"               => [],
			"background_color_from"      => [],
			"background_color_to"        => [],
			"gradient_direction"         => [],
			"border_top_width"           => [],
			"border_top_left_radius"     => [],
			"border_right_width"         => [],
			"border_top_right_radius"    => [],
			"border_bottom_width"        => [],
			"border_bottom_right_radius" => [],
			"border_left_width"          => [],
			"border_bottom_left_radius"  => [],
			"border_color"               => [],
			"border_style"               => [],
		];
	}

	/**
	 * Labels
	 *
	 * @return array
	 */
	public function labels()
	{
		return [];
	}

	/**
	 * Relations
	 *
	 * @return array
	 */
	public function relations()
	{
		return [];
	}

	/**
	 * Gets model object
	 *
	 * @return DesignBlockModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		parent::beforeValidate();

		if (!$this->margin_top) {
			$this->margin_top = 0;
		}
		if (!$this->margin_right) {
			$this->margin_right = 0;
		}
		if (!$this->margin_bottom) {
			$this->margin_bottom = 0;
		}
		if (!$this->margin_left) {
			$this->margin_left = 0;
		}
		if (!$this->padding_top) {
			$this->padding_top = 0;
		}
		if (!$this->padding_right) {
			$this->padding_right = 0;
		}
		if (!$this->padding_bottom) {
			$this->padding_bottom = 0;
		}
		if (!$this->padding_left) {
			$this->padding_left = 0;
		}
		if (!$this->background_color_from) {
			$this->background_color_from = "";
		}
		if (!$this->background_color_to) {
			$this->background_color_to = "";
		}
		if (!$this->gradient_direction) {
			$this->gradient_direction = 0;
		}
		if (!$this->border_top_width) {
			$this->border_top_width = 0;
		}
		if (!$this->border_top_left_radius) {
			$this->border_top_left_radius = 0;
		}
		if (!$this->border_right_width) {
			$this->border_right_width = 0;
		}
		if (!$this->border_top_right_radius) {
			$this->border_top_right_radius = 0;
		}
		if (!$this->border_bottom_width) {
			$this->border_bottom_width = 0;
		}
		if (!$this->border_bottom_right_radius) {
			$this->border_bottom_right_radius = 0;
		}
		if (!$this->border_left_width) {
			$this->border_left_width = 0;
		}
		if (!$this->border_bottom_left_radius) {
			$this->border_bottom_left_radius = 0;
		}
		if (!$this->border_color) {
			$this->border_color = "";
		}
		if (!$this->border_style) {
			$this->border_style = 0;
		}
	}

	/**
	 * Gets values for object
	 *
	 * @param string $name Name of object
	 *
	 * @return array
	 */
	public function getValues($name)
	{
		return [
			"margin_top"                 => [
				"name"  => "{$name}.margin_top",
				"value" => $this->margin_top
			],
			"margin_right"               => [
				"name"  => "{$name}.margin_right",
				"value" => $this->margin_right
			],
			"margin_bottom"              => [
				"name"  => "{$name}.margin_bottom",
				"value" => $this->margin_bottom
			],
			"margin_left"                => [
				"name"  => "{$name}.margin_left",
				"value" => $this->margin_left
			],
			"padding_top"                => [
				"name"  => "{$name}.padding_top",
				"value" => $this->padding_top
			],
			"padding_right"              => [
				"name"  => "{$name}.padding_right",
				"value" => $this->padding_right
			],
			"padding_bottom"             => [
				"name"  => "{$name}.padding_bottom",
				"value" => $this->padding_bottom
			],
			"padding_left"               => [
				"name"  => "{$name}.padding_left",
				"value" => $this->padding_left
			],
			"background_color_from"      => [
				"name"  => "{$name}.background_color_from",
				"value" => $this->background_color_from
			],
			"background_color_to"        => [
				"name"  => "{$name}.background_color_to",
				"value" => $this->background_color_to
			],
			"gradient_direction"         => [
				"name"  => "{$name}.gradient_direction",
				"value" => $this->gradient_direction
			],
			"border_top_width"           => [
				"name"  => "{$name}.border_top_width",
				"value" => $this->border_top_width
			],
			"border_top_left_radius"     => [
				"name"  => "{$name}.border_top_left_radius",
				"value" => $this->border_top_left_radius
			],
			"border_right_width"         => [
				"name"  => "{$name}.border_right_width",
				"value" => $this->border_right_width
			],
			"border_top_right_radius"    => [
				"name"  => "{$name}.border_top_right_radius",
				"value" => $this->border_top_right_radius
			],
			"border_bottom_width"        => [
				"name"  => "{$name}.border_bottom_width",
				"value" => $this->border_bottom_width
			],
			"border_bottom_right_radius" => [
				"name"  => "{$name}.border_bottom_right_radius",
				"value" => $this->border_bottom_right_radius
			],
			"border_left_width"          => [
				"name"  => "{$name}.border_left_width",
				"value" => $this->border_left_width
			],
			"border_bottom_left_radius"  => [
				"name"  => "{$name}.border_bottom_left_radius",
				"value" => $this->border_bottom_left_radius
			],
			"border_color"               => [
				"name"  => "{$name}.border_color",
				"value" => $this->border_color
			],
			"border_style"               => [
				"name"  => "{$name}.border_style",
				"value" => $this->border_style
			],
		];
	}

	/**
	 * Gets gradient direction
	 *
	 * @return array
	 */
	public function getGradientDirection()
	{
		if (array_key_exists($this->gradient_direction, self::$gradientDirectionList)) {
			return self::$gradientDirectionList[$this->gradient_direction];
		}

		return self::$gradientDirectionList[self::GRADIENT_DIRECTION_HORIZONTAL];
	}

	/**
	 * Gets border style
	 *
	 * @return string
	 */
	public function getBorderStyle()
	{
		if (array_key_exists($this->border_style, self::$borderStyleList)) {
			return self::$borderStyleList[$this->border_style];
		}

		return self::$borderStyleList[self::BORDER_STYLE_NONE];
	}
}