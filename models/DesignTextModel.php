<?php

namespace models;

use system\base\Model;

/**
 * Model for working with table "design_texts"
 *
 * @package models
 */
class DesignTextModel extends Model
{

	/**
	 * Value for replace
	 */
	const REPLACE_VALUE = "__";

	/**
	 * Default line-heght value
	 */
	const DEFAULT_LINE_HEIGHT = 140;

	/**
	 * Font family type. MyriadPro
	 */
	const FAMILY_MYRAD = 0;

	/**
	 * Font family type. Arial
	 */
	const FAMILY_ARIAL = 1;

	/**
	 * Font family type. Arial Black
	 */
	const FAMILY_ARIAL_BLACK = 2;

	/**
	 * Font family type. Comic Sans MS
	 */
	const FAMILY_COMIC_SANS_MS = 3;

	/**
	 * Font family type. Courier New
	 */
	const FAMILY_COURIER_NEW = 4;

	/**
	 * Font family type. Georgia
	 */
	const FAMILY_GEORGIA = 5;

	/**
	 * Font family type. Impact
	 */
	const FAMILY_IMPACT = 6;

	/**
	 * Font family type. Monaco
	 */
	const FAMILY_MONACO = 7;

	/**
	 * Font family type. Lucida Sans Unicode
	 */
	const FAMILY_LUCIDA_GRANDE = 8;

	/**
	 * Font family type. Palatino Linotype
	 */
	const FAMILY_PALATINO = 9;

	/**
	 * Font family type. Tahoma
	 */
	const FAMILY_TAHOMA = 10;

	/**
	 * Font family type. Times New Roman
	 */
	const FAMILY_TIMES = 11;

	/**
	 * Font family type. Helvetica
	 */
	const FAMILY_HELVETICA = 12;

	/**
	 * Font family type. Verdana
	 */
	const FAMILY_VERDANA = 13;

	/**
	 * Font family type. Geneva
	 */
	const FAMILY_GENEVA = 14;

	/**
	 * Font family type. MS Serif
	 */
	const FAMILY_MS_SERIF = 15;

	/**
	 * Text align type. Left
	 */
	const TEXT_ALIGN_LEFT = 0;

	/**
	 * Text align type. Center
	 */
	const TEXT_ALIGN_CENTER = 1;

	/**
	 * Text align type. Right
	 */
	const TEXT_ALIGN_RIGHT = 2;

	/**
	 * Text align type. Justify
	 */
	const TEXT_ALIGN_JUSTIFY = 3;

	/**
	 * Text decoration type. None
	 */
	const TEXT_DECORATION_NONE = 0;

	/**
	 * Text decoration type. Underline
	 */
	const TEXT_DECORATION_UNDERLINE = 1;

	/**
	 * Text decoration type. Line through
	 */
	const TEXT_DECORATION_LINE_THROUGH = 2;

	/**
	 * Text decoration type. Overline
	 */
	const TEXT_DECORATION_OVERLINE = 3;

	/**
	 * Text transform type. None
	 */
	const TEXT_TRANSFORM_NONE = 0;

	/**
	 * Text transform type. Uppercase
	 */
	const TEXT_TRANSFORM_UPPERCASE = 1;

	/**
	 * Text transform type. Lowercase
	 */
	const TEXT_TRANSFORM_LOWERCASE = 2;

	/**
	 * Text transform type. Capitalize
	 */
	const TEXT_TRANSFORM_CAPITALIZE = 3;

	/**
	 * CSS font-size in px
	 *
	 * @var int
	 */
	public $size;

	/**
	 * Font family
	 *
	 * @var int
	 */
	public $family;

	/**
	 * CSS color
	 *
	 * @var string
	 */
	public $color;

	/**
	 * Is font-style: italic
	 *
	 * @var bool
	 */
	public $is_italic;

	/**
	 * Is font-weight: bold;
	 *
	 * @var int
	 */
	public $is_bold;

	/**
	 * Align type
	 *
	 * @var int
	 */
	public $align;

	/**
	 * Text decoration type
	 *
	 * @var int
	 */
	public $decoration;

	/**
	 * Text transform type
	 *
	 * @var int
	 */
	public $transform;

	/**
	 * CSS letter-spacing in px
	 *
	 * @var int
	 */
	public $letter_spacing;

	/**
	 * CSS line-height in %
	 *
	 * @var int
	 */
	public $line_height;

	/**
	 * List of font family types
	 *
	 * @var array
	 */
	public static $familyList = [
		self::FAMILY_MYRAD         => [
			"class" => "l-font-family-myrad",
			"name"  => "MyriadPro"
		],
		self::FAMILY_ARIAL         => [
			"class" => "l-font-family-arial",
			"name"  => "Arial, Helvetica"
		],
		self::FAMILY_ARIAL_BLACK   => [
			"class" => "l-font-family-arial-black",
			"name"  => "Arial Black, Gadget"
		],
		self::FAMILY_COMIC_SANS_MS => [
			"class" => "l-font-family-comic-sans",
			"name"  => "Comic Sans MS"
		],
		self::FAMILY_COURIER_NEW   => [
			"class" => "l-font-family-courier-new",
			"name"  => "Courier New"
		],
		self::FAMILY_GEORGIA       => [
			"class" => "l-font-family-georgia",
			"name"  => "Georgia"
		],
		self::FAMILY_IMPACT        => [
			"class" => "l-font-family-impact",
			"name"  => "Impact, Charcoal"
		],
		self::FAMILY_MONACO        => [
			"class" => "l-font-family-monaco",
			"name"  => "Lucida Console, Monaco"
		],
		self::FAMILY_LUCIDA_GRANDE => [
			"class" => "l-font-family-lucida-grande",
			"name"  => "Lucida Sans Unicode"
		],
		self::FAMILY_PALATINO      => [
			"class" => "l-font-family-palatino",
			"name"  => "Palatino"
		],
		self::FAMILY_TAHOMA        => [
			"class" => "l-font-family-tahoma",
			"name"  => "Tahoma, Geneva"
		],
		self::FAMILY_TIMES         => [
			"class" => "l-font-family-times",
			"name"  => "Times New Roman, Times"
		],
		self::FAMILY_HELVETICA     => [
			"class" => "l-font-family-helvetica",
			"name"  => "Trebuchet MS, Helvetica"
		],
		self::FAMILY_VERDANA       => [
			"class" => "l-font-family-verdana",
			"name"  => "Verdana, Geneva"
		],
		self::FAMILY_GENEVA        => [
			"class" => "l-font-family-geneva",
			"name"  => "MS Sans Serif, Geneva"
		],
		self::FAMILY_MS_SERIF      => [
			"class" => "l-font-family-ms-serif",
			"name"  => "MS Serif, New York"
		]
	];

	/**
	 * List of text align types
	 *
	 * @var array
	 */
	public static $textAlignList = [
		self::TEXT_ALIGN_LEFT    => "left",
		self::TEXT_ALIGN_CENTER  => "center",
		self::TEXT_ALIGN_RIGHT   => "right",
		self::TEXT_ALIGN_JUSTIFY => "justify",
	];

	/**
	 * List of text decoration types
	 *
	 * @var array
	 */
	public static $textDecorationList = [
		self::TEXT_DECORATION_NONE         => "none",
		self::TEXT_DECORATION_UNDERLINE    => "underline",
		self::TEXT_DECORATION_LINE_THROUGH => "line-through",
		self::TEXT_DECORATION_OVERLINE     => "overline",
	];

	/**
	 * List of text transform types
	 *
	 * @var array
	 */
	public static $textTransformList = [
		self::TEXT_TRANSFORM_NONE       => "none",
		self::TEXT_TRANSFORM_UPPERCASE  => "uppercase",
		self::TEXT_TRANSFORM_LOWERCASE  => "lowercase",
		self::TEXT_TRANSFORM_CAPITALIZE => "capitalize",
	];

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"size"           => [],
			"family"         => [],
			"color"          => [],
			"is_italic"      => [],
			"is_bold"        => [],
			"align"          => [],
			"decoration"     => [],
			"transform"      => [],
			"letter_spacing" => [],
			"line_height"    => [],
		];
	}

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "design_texts";
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

		if (!$this->size) {
			$this->size = 0;
		}
		if (!$this->family) {
			$this->family = 0;
		}
		if (!$this->color) {
			$this->color = "";
		}
		if (!$this->is_italic) {
			$this->is_italic = 0;
		}
		if (!$this->is_bold) {
			$this->is_bold = 0;
		}
		if (!$this->align) {
			$this->align = 0;
		}
		if (!$this->decoration) {
			$this->decoration = 0;
		}
		if (!$this->transform) {
			$this->transform = 0;
		}
		if (!$this->letter_spacing) {
			$this->letter_spacing = 0;
		}
		if (!$this->line_height) {
			$this->line_height = self::DEFAULT_LINE_HEIGHT;
		}
	}

	/**
	 * Gets values for object
	 *
	 * @param string $name Object name
	 *
	 * @return array
	 */
	public function getValues($name)
	{
		return [
			"fontFamily"     => [
				"name"  => sprintf($name, "family"),
				"value" => $this->family
			],
			"spinners" => [
				[
					"name"     => sprintf($name, "size"),
					"value"    => $this->size,
					"type"     => "font-size",
					"minValue" => 4,
					"measure"  => "px"
				],
                [
                    "name"     => sprintf($name, "letter_spacing"),
                    "value"    => $this->letter_spacing,
                    "type"     => "letter-spacing",
                    "minValue" => -10,
                    "measure"  => "px"
                ],
                [
                    "name"     => sprintf($name, "line_height"),
                    "value"    => $this->line_height,
                    "type"     => "line-height",
                    "minValue" => 10,
                    "measure"  => "%"
                ]
			],
            "colors"           => [
                [
                    "type"  => "color",
                    "name"  => sprintf($name, "color"),
                    "value" => $this->color
                ]
            ],
			"checkboxes" => [
				[
					"name"      => sprintf($name, "is_italic"),
					"value"     => $this->is_italic,
					"type"      => "font-style",
					"checked"   => "italic",
					"unChecked" => "normal"
				],
				[
					"name"      => sprintf($name, "is_bold"),
					"value"     => $this->is_bold,
					"type"      => "font-weight",
					"checked"   => "bold",
					"unChecked" => "normal"
				]
			],
            "radios"           => [
                [
                    "type"  => "text-align",
                    "name"  => sprintf($name, "align"),
                    "value" => $this->align
                ],
                [
                    "type"  => "text-decoration",
                    "name"  => sprintf($name, "decoration"),
                    "value" => $this->decoration
                ],
                [
                    "type"  => "text-transform",
                    "name"  => sprintf($name, "transform"),
                    "value" => $this->transform
                ]
            ]
		];
	}

	/**
	 * Gets CSS text-align value
	 *
	 * @return string
	 */
	public function getTextAlign()
	{
		if (array_key_exists($this->align, self::$textAlignList)) {
			return self::$textAlignList[$this->align];
		}

		return "";
	}

	/**
	 * Gets CSS text-decoration value
	 *
	 * @return string
	 */
	public function getTextDecoration()
	{
		if (array_key_exists($this->decoration, self::$textDecorationList)) {
			return self::$textDecorationList[$this->decoration]["value"];
		}

		return "";
	}

	/**
	 * Gets CSS text-transform value
	 *
	 * @return string
	 */
	public function getTextTransform()
	{
		if (array_key_exists($this->transform, self::$textTransformList)) {
			return self::$textTransformList[$this->transform]["value"];
		}

		return "";
	}

	/**
	 * Gets CSS font-family value
	 *
	 * @return string
	 */
	public function getFontFamilyClass()
	{
		if (array_key_exists($this->family, self::$familyList)) {
			return self::$familyList[$this->family]["class"];
		}

		return "";
	}
}