<?php

namespace models;

use system\base\Model;

/**
 * Model for working with table "design_blocks"
 *
 * @package models
 */
class DesignBlockModel extends Model
{

	/**
	 * Value for replace
	 */
	const REPLACE_VALUE = "__";

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
	 * CSS margin-top in px
	 *
	 * @var int
	 */
	public $margin_top;

	/**
	 * CSS margin-right in px
	 *
	 * @var int
	 */
	public $margin_right;

	/**
	 * CSS margin-bottom in px
	 *
	 * @var int
	 */
	public $margin_bottom;

	/**
	 * CSS margin-left in px
	 *
	 * @var int
	 */
	public $margin_left;

	/**
	 * CSS padding-top in px
	 *
	 * @var int
	 */
	public $padding_top;

	/**
	 * CSS padding-right in px
	 *
	 * @var int
	 */
	public $padding_right;

	/**
	 * CSS padding-bottom in px
	 *
	 * @var int
	 */
	public $padding_bottom;

	/**
	 * CSS padding-left in px
	 *
	 * @var int
	 */
	public $padding_left;

	/**
	 * CSS background-color (from)
	 * used in gradient or simple background-color
	 *
	 * @var string
	 */
	public $background_color_from;

	/**
	 * CSS background-color (to)
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
	 * CSS border-top-width in px
	 *
	 * @var int
	 */
	public $border_top_width;

	/**
	 * CSS border-top-left-radius in px
	 *
	 * @var int
	 */
	public $border_top_left_radius;

	/**
	 * CSS border-right-width in px
	 *
	 * @var int
	 */
	public $border_right_width;

	/**
	 * CSS border-top-right-radius in px
	 *
	 * @var int
	 */
	public $border_top_right_radius;

	/**
	 * CSS border-bottom-width in px
	 *
	 * @var int
	 */
	public $border_bottom_width;

	/**
	 * CSS border-bottom-right-radius in px
	 *
	 * @var int
	 */
	public $border_bottom_right_radius;

	/**
	 * CSS border-left-width in px
	 *
	 * @var int
	 */
	public $border_left_width;

	/**
	 * CSS border-bottom-left-radius in px
	 *
	 * @var int
	 */
	public $border_bottom_left_radius;

	/**
	 * CSS border-color
	 *
	 * @var string
	 */
	public $border_color;

	/**
	 * Border style
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
	public function getTableName()
	{
		return "design_blocks";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
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
			"angles"          => [
				[
					"type"   => "margin",
					"values" => [
						[
							"name"  => sprintf($name, "margin_top"),
							"value" => $this->margin_top
						],
						[
							"name"  => sprintf($name, "margin_right"),
							"value" => $this->margin_right
						],
						[
							"name"  => sprintf($name, "margin_bottom"),
							"value" => $this->margin_bottom
						],
						[
							"name"  => sprintf($name, "margin_left"),
							"value" => $this->margin_left
						]
					]
				],
				[
					"type"   => "padding",
					"values" => [
						[
							"name"  => sprintf($name, "padding_top"),
							"value" => $this->padding_top
						],
						[
							"name"  => sprintf($name, "padding_right"),
							"value" => $this->padding_right
						],
						[
							"name"  => sprintf($name, "padding_bottom"),
							"value" => $this->padding_bottom
						],
						[
							"name"  => sprintf($name, "padding_left"),
							"value" => $this->padding_left
						]
					]
				],
				[
					"type"   => "border-width",
					"values" => [
						[
							"name"  => sprintf($name, "border_top_width"),
							"value" => $this->border_top_width
						],
						[
							"name"  => sprintf($name, "border_right_width"),
							"value" => $this->border_right_width
						],
						[
							"name"  => sprintf($name, "border_bottom_width"),
							"value" => $this->border_bottom_width
						],
						[
							"name"  => sprintf($name, "border_left_width"),
							"value" => $this->border_left_width
						]
					]
				],
				[
					"type"   => "border-radius",
					"values" => [
						[
							"name"  => sprintf($name, "border_top_left_radius"),
							"value" => $this->border_top_left_radius
						],
						[
							"name"  => sprintf($name, "border_top_right_radius"),
							"value" => $this->border_top_right_radius
						],
						[
							"name"  => sprintf($name, "border_bottom_right_radius"),
							"value" => $this->border_bottom_right_radius
						],
						[
							"name"  => sprintf($name, "border_bottom_left_radius"),
							"value" => $this->border_bottom_left_radius
						]
					]
				],
			],
			"backgroundColor" => [
				"fromName"      => sprintf($name, "background_color_from"),
				"fromValue"     => $this->background_color_from,
				"toName"        => sprintf($name, "background_color_to"),
				"toValue"       => $this->background_color_to,
				"gradientName"  => sprintf($name, "gradient_direction"),
				"gradientValue" => $this->gradient_direction
			],
			"color"           => [
				[
					"type"  => "border-color",
					"name"  => sprintf($name, "border_color"),
					"value" => $this->border_color
				]
			],
			"radios"           => [
				[
					"type"  => "border-style",
					"name"  => sprintf($name, "border_style"),
					"value" => $this->border_style
				]
			]
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