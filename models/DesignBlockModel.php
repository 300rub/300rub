<?php

namespace models;

use system\base\Model;

/**
 * @package models
 */
class DesignBlockModel extends Model
{

	/**
	 * @var int
	 */
	public $margin_top;

	/**
	 * @var int
	 */
	public $margin_right;

	/**
	 * @var int
	 */
	public $margin_bottom;

	/**
	 * @var int
	 */
	public $margin_left;

	/**
	 * @var int
	 */
	public $padding_top;

	/**
	 * @var int
	 */
	public $padding_right;

	/**
	 * @var int
	 */
	public $padding_bottom;

	/**
	 * @var int
	 */
	public $padding_left;

	/**
	 * @var string
	 */
	public $background_color_from;

	/**
	 * @var string
	 */
	public $background_color_to;

	/**
	 * @var int
	 */
	public $gradient_direction;

	/**
	 * @var int
	 */
	public $border_top_width;

	/**
	 * @var int
	 */
	public $border_top_left_radius;

	/**
	 * @var int
	 */
	public $border_right_width;

	/**
	 * @var int
	 */
	public $border_top_right_radius;

	/**
	 * @var int
	 */
	public $border_bottom_width;

	/**
	 * @var int
	 */
	public $border_bottom_right_radius;

	/**
	 * @var int
	 */
	public $border_left_width;

	/**
	 * @var int
	 */
	public $border_bottom_left_radius;

	/**
	 * @var string
	 */
	public $border_color;

	/**
	 * @var int
	 */
	public $border_style;

	const GRADIENT_DIRECTION_HORIZONTAL = 0;
	const GRADIENT_DIRECTION_VERTICAL = 1;
	const GRADIENT_DIRECTION_135DEG = 2;
	const GRADIENT_DIRECTION_45DEG = 3;

	/**
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

	const BORDER_STYLE_NONE = 0;
	const BORDER_STYLE_SOLID = 1;
	const BORDER_STYLE_DOTTED = 2;
	const BORDER_STYLE_DASHED = 3;

	/**
	 * @var array
	 */
	public static $borderStyleList = [
		self::BORDER_STYLE_NONE   => "none",
		self::BORDER_STYLE_SOLID  => "solid",
		self::BORDER_STYLE_DOTTED => "dotted",
		self::BORDER_STYLE_DASHED => "dashed",
	];

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "design_blocks";
	}

	/**
	 * Правила валидации
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
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return [];
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return [];
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return DesignBlockModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

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
	 * @param string $name
	 *
	 * @return array
	 */
	public function getValues($name)
	{
		return [
			"margin_top"                 => [
				"name"  => "Data[{$name}.margin_top]",
				"value" => $this->margin_top
			],
			"margin_right"               => [
				"name"  => "Data[{$name}.margin_right]",
				"value" => $this->margin_right
			],
			"margin_bottom"              => [
				"name"  => "Data[{$name}.margin_bottom]",
				"value" => $this->margin_bottom
			],
			"margin_left"                => [
				"name"  => "Data[{$name}.margin_left]",
				"value" => $this->margin_left
			],
			"padding_top"                => [
				"name"  => "Data[{$name}.padding_top]",
				"value" => $this->padding_top
			],
			"padding_right"              => [
				"name"  => "Data[{$name}.padding_right]",
				"value" => $this->padding_right
			],
			"padding_bottom"             => [
				"name"  => "Data[{$name}.padding_bottom]",
				"value" => $this->padding_bottom
			],
			"padding_left"               => [
				"name"  => "Data[{$name}.padding_left]",
				"value" => $this->padding_left
			],
			"background_color_from"      => [
				"name"  => "Data[{$name}.background_color_from]",
				"value" => $this->background_color_from
			],
			"background_color_to"        => [
				"name"  => "Data[{$name}.background_color_to]",
				"value" => $this->background_color_to
			],
			"gradient_direction"         => [
				"name"  => "Data[{$name}.gradient_direction]",
				"value" => $this->gradient_direction
			],
			"border_top_width"           => [
				"name"  => "Data[{$name}.border_top_width]",
				"value" => $this->border_top_width
			],
			"border_top_left_radius"     => [
				"name"  => "Data[{$name}.border_top_left_radius]",
				"value" => $this->border_top_left_radius
			],
			"border_right_width"         => [
				"name"  => "Data[{$name}.border_right_width]",
				"value" => $this->border_right_width
			],
			"border_top_right_radius"    => [
				"name"  => "Data[{$name}.border_top_right_radius]",
				"value" => $this->border_top_right_radius
			],
			"border_bottom_width"        => [
				"name"  => "Data[{$name}.border_bottom_width]",
				"value" => $this->border_bottom_width
			],
			"border_bottom_right_radius" => [
				"name"  => "Data[{$name}.border_bottom_right_radius]",
				"value" => $this->border_bottom_right_radius
			],
			"border_left_width"          => [
				"name"  => "Data[{$name}.border_left_width]",
				"value" => $this->border_left_width
			],
			"border_bottom_left_radius"  => [
				"name"  => "Data[{$name}.border_bottom_left_radius]",
				"value" => $this->border_bottom_left_radius
			],
			"border_color"               => [
				"name"  => "Data[{$name}.border_color]",
				"value" => $this->border_color
			],
			"border_style"               => [
				"name"  => "Data[{$name}.border_style]",
				"value" => $this->border_style
			],
		];
	}

	/**
	 * @return array
	 */
	public function getGradientDirections()
	{
		if (array_key_exists($this->gradient_direction, self::$gradientDirectionList)) {
			return self::$gradientDirectionList[$this->gradient_direction];
		}

		return self::$gradientDirectionList[self::GRADIENT_DIRECTION_HORIZONTAL];
	}

	/**
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