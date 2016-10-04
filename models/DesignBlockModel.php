<?php

namespace testS\models;

use testS\components\exceptions\ModelException;

/**
 * Model for working with table "designBlocks"
 *
 * @package models
 */
class DesignBlockModel extends AbstractModel
{

	/**
	 * Min margin value
	 */
	const MIN_MARGIN_VALUE = -300;

	/**
	 * Min padding value
	 */
	const MIN_PADDING_VALUE = 0;

	/**
	 * Min border width value
	 */
	const MIN_BORDER_WIDTH_VALUE = 0;

	/**
	 * Min border radius value
	 */
	const MIN_BORDER_RADIUS_VALUE = 0;

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
	public $marginTop;

	/**
	 * CSS margin-right in px
	 *
	 * @var int
	 */
	public $marginRight;

	/**
	 * CSS margin-bottom in px
	 *
	 * @var int
	 */
	public $marginBottom;

	/**
	 * CSS margin-left in px
	 *
	 * @var int
	 */
	public $marginLeft;

	/**
	 * CSS padding-top in px
	 *
	 * @var int
	 */
	public $paddingTop;

	/**
	 * CSS padding-right in px
	 *
	 * @var int
	 */
	public $paddingRight;

	/**
	 * CSS padding-bottom in px
	 *
	 * @var int
	 */
	public $paddingBottom;

	/**
	 * CSS padding-left in px
	 *
	 * @var int
	 */
	public $paddingLeft;

	/**
	 * CSS background-color (from)
	 * used in gradient or simple background-color
	 *
	 * @var string
	 */
	public $backgroundColorFrom;

	/**
	 * CSS background-color (to)
	 * used in gradient or simple background-color
	 *
	 * @var string
	 */
	public $backgroundColorTo;

	/**
	 * Gradient direction
	 *
	 * @var int
	 */
	public $gradientDirection;

	/**
	 * CSS border-top-width in px
	 *
	 * @var int
	 */
	public $borderTopWidth;

	/**
	 * CSS border-top-left-radius in px
	 *
	 * @var int
	 */
	public $borderTopLeftRadius;

	/**
	 * CSS border-right-width in px
	 *
	 * @var int
	 */
	public $borderRightWidth;

	/**
	 * CSS border-top-right-radius in px
	 *
	 * @var int
	 */
	public $borderTopRightRadius;

	/**
	 * CSS border-bottom-width in px
	 *
	 * @var int
	 */
	public $borderBottomWidth;

	/**
	 * CSS border-bottom-right-radius in px
	 *
	 * @var int
	 */
	public $borderBottomRightRadius;

	/**
	 * CSS border-left-width in px
	 *
	 * @var int
	 */
	public $borderLeftWidth;

	/**
	 * CSS border-bottom-left-radius in px
	 *
	 * @var int
	 */
	public $borderBottomLeftRadius;

	/**
	 * CSS border-color
	 *
	 * @var string
	 */
	public $borderColor;

	/**
	 * Border style
	 *
	 * @var int
	 */
	public $borderStyle;

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
		return "designBlocks";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"marginTop"                 => [],
			"marginRight"               => [],
			"marginBottom"              => [],
			"marginLeft"                => [],
			"paddingTop"                => [],
			"paddingRight"              => [],
			"paddingBottom"             => [],
			"paddingLeft"               => [],
			"backgroundColorFrom"      => [],
			"backgroundColorTo"        => [],
			"gradientDirection"         => [],
			"borderTopWidth"           => [],
			"borderTopLeftRadius"     => [],
			"borderRightWidth"         => [],
			"borderTopRightRadius"    => [],
			"borderBottomWidth"        => [],
			"borderBottomRightRadius" => [],
			"borderLeftWidth"          => [],
			"borderBottomLeftRadius"  => [],
			"borderColor"               => [],
			"borderStyle"               => [],
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
	 * Sets values
	 */
	protected function setValues()
	{
		$this->marginTop = intval($this->marginTop);
		if ($this->marginTop < self::MIN_MARGIN_VALUE) {
			$this->marginTop = self::MIN_MARGIN_VALUE;
		}
		$this->marginRight = intval($this->marginRight);
		if ($this->marginRight < self::MIN_MARGIN_VALUE) {
			$this->marginRight = self::MIN_MARGIN_VALUE;
		}
		$this->marginBottom = intval($this->marginBottom);
		if ($this->marginBottom < self::MIN_MARGIN_VALUE) {
			$this->marginBottom = self::MIN_MARGIN_VALUE;
		}
		$this->marginLeft = intval($this->marginLeft);
		if ($this->marginLeft < self::MIN_MARGIN_VALUE) {
			$this->marginLeft = self::MIN_MARGIN_VALUE;
		}

		$this->paddingTop = intval($this->paddingTop);
		if ($this->paddingTop < self::MIN_PADDING_VALUE) {
			$this->paddingTop = self::MIN_PADDING_VALUE;
		}
		$this->paddingRight = intval($this->paddingRight);
		if ($this->paddingRight < self::MIN_PADDING_VALUE) {
			$this->paddingRight = self::MIN_PADDING_VALUE;
		}
		$this->paddingBottom = intval($this->paddingBottom);
		if ($this->paddingBottom < self::MIN_PADDING_VALUE) {
			$this->paddingBottom = self::MIN_PADDING_VALUE;
		}
		$this->paddingLeft = intval($this->paddingLeft);
		if ($this->paddingLeft < self::MIN_PADDING_VALUE) {
			$this->paddingLeft = self::MIN_PADDING_VALUE;
		}

		if (!$this->_isColor($this->backgroundColorFrom)) {
			$this->backgroundColorFrom = "";
		}
		if (!$this->_isColor($this->backgroundColorTo)) {
			$this->backgroundColorTo = "";
		}
		$this->gradientDirection = intval($this->gradientDirection);
		if (!array_key_exists($this->gradientDirection, self::$gradientDirectionList)) {
			$this->gradientDirection = self::GRADIENT_DIRECTION_HORIZONTAL;
		}

		$this->borderTopWidth = intval($this->borderTopWidth);
		if ($this->borderTopWidth < self::MIN_BORDER_WIDTH_VALUE) {
			$this->borderTopWidth = self::MIN_BORDER_WIDTH_VALUE;
		}
		$this->borderRightWidth = intval($this->borderRightWidth);
		if ($this->borderRightWidth < self::MIN_BORDER_WIDTH_VALUE) {
			$this->borderRightWidth = self::MIN_BORDER_WIDTH_VALUE;
		}
		$this->borderBottomWidth = intval($this->borderBottomWidth);
		if ($this->borderBottomWidth < self::MIN_BORDER_WIDTH_VALUE) {
			$this->borderBottomWidth = self::MIN_BORDER_WIDTH_VALUE;
		}
		$this->borderLeftWidth = intval($this->borderLeftWidth);
		if ($this->borderLeftWidth < self::MIN_BORDER_WIDTH_VALUE) {
			$this->borderLeftWidth = self::MIN_BORDER_WIDTH_VALUE;
		}

		$this->borderTopLeftRadius = intval($this->borderTopLeftRadius);
		if ($this->borderTopLeftRadius < self::MIN_BORDER_RADIUS_VALUE) {
			$this->borderTopLeftRadius = self::MIN_BORDER_RADIUS_VALUE;
		}
		$this->borderTopRightRadius = intval($this->borderTopRightRadius);
		if ($this->borderTopRightRadius < self::MIN_BORDER_RADIUS_VALUE) {
			$this->borderTopRightRadius = self::MIN_BORDER_RADIUS_VALUE;
		}
		$this->borderBottomRightRadius = intval($this->borderBottomRightRadius);
		if ($this->borderBottomRightRadius < self::MIN_BORDER_RADIUS_VALUE) {
			$this->borderBottomRightRadius = self::MIN_BORDER_RADIUS_VALUE;
		}
		$this->borderBottomLeftRadius = intval($this->borderBottomLeftRadius);
		if ($this->borderBottomLeftRadius < self::MIN_BORDER_RADIUS_VALUE) {
			$this->borderBottomLeftRadius = self::MIN_BORDER_RADIUS_VALUE;
		}

		if (!$this->_isColor($this->borderColor)) {
			$this->borderColor = "";
		}
		$this->borderStyle = intval($this->borderStyle);
		if (!array_key_exists($this->borderStyle, self::$borderStyleList)) {
			$this->borderStyle = self::BORDER_STYLE_NONE;
		}
	}

	/**
	 * Checks is it correct color value
	 *
	 * @param string $value Color value
	 *
	 * @return bool
	 */
	private function _isColor($value)
	{
		return boolval(preg_match('/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i', $value));
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
							"name"  => sprintf($name, "marginTop"),
							"value" => $this->marginTop
						],
						[
							"name"  => sprintf($name, "marginRight"),
							"value" => $this->marginRight
						],
						[
							"name"  => sprintf($name, "marginBottom"),
							"value" => $this->marginBottom
						],
						[
							"name"  => sprintf($name, "marginLeft"),
							"value" => $this->marginLeft
						]
					]
				],
				[
					"type"   => "padding",
					"values" => [
						[
							"name"  => sprintf($name, "paddingTop"),
							"value" => $this->paddingTop
						],
						[
							"name"  => sprintf($name, "paddingRight"),
							"value" => $this->paddingRight
						],
						[
							"name"  => sprintf($name, "paddingBottom"),
							"value" => $this->paddingBottom
						],
						[
							"name"  => sprintf($name, "paddingLeft"),
							"value" => $this->paddingLeft
						]
					]
				],
				[
					"type"   => "border-width",
					"values" => [
						[
							"name"  => sprintf($name, "borderTopWidth"),
							"value" => $this->borderTopWidth
						],
						[
							"name"  => sprintf($name, "borderRightWidth"),
							"value" => $this->borderRightWidth
						],
						[
							"name"  => sprintf($name, "borderBottomWidth"),
							"value" => $this->borderBottomWidth
						],
						[
							"name"  => sprintf($name, "borderLeftWidth"),
							"value" => $this->borderLeftWidth
						]
					]
				],
				[
					"type"   => "border-radius",
					"values" => [
						[
							"name"  => sprintf($name, "borderTopLeftRadius"),
							"value" => $this->borderTopLeftRadius
						],
						[
							"name"  => sprintf($name, "borderTopRightRadius"),
							"value" => $this->borderTopRightRadius
						],
						[
							"name"  => sprintf($name, "borderBottomRightRadius"),
							"value" => $this->borderBottomRightRadius
						],
						[
							"name"  => sprintf($name, "borderBottomLeftRadius"),
							"value" => $this->borderBottomLeftRadius
						]
					]
				],
			],
			"backgroundColor" => [
				"fromName"      => sprintf($name, "backgroundColorFrom"),
				"fromValue"     => $this->backgroundColorFrom,
				"toName"        => sprintf($name, "backgroundColorTo"),
				"toValue"       => $this->backgroundColorTo,
				"gradientName"  => sprintf($name, "gradientDirection"),
				"gradientValue" => $this->gradientDirection
			],
			"colors"           => [
				[
					"type"  => "border-color",
					"name"  => sprintf($name, "borderColor"),
					"value" => $this->borderColor
				]
			],
			"radios"           => [
				[
					"type"  => "border-style",
					"name"  => sprintf($name, "borderStyle"),
					"value" => $this->borderStyle
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
		if (array_key_exists($this->gradientDirection, self::$gradientDirectionList)) {
			return self::$gradientDirectionList[$this->gradientDirection];
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
		if (array_key_exists($this->borderStyle, self::$borderStyleList)) {
			return self::$borderStyleList[$this->borderStyle];
		}

		return self::$borderStyleList[self::BORDER_STYLE_NONE];
	}

	/**
	 * Duplicates model
	 *
	 * @return DesignBlockModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate()
	{
		$model = clone $this;
		$model->id = 0;

		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate DesignBlockModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}
		return $model;
	}
}