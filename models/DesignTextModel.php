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
			"class" => "font-family-myrad",
			"name"  => "MyriadPro"
		],
		self::FAMILY_ARIAL         => [
			"class" => "font-family-arial",
			"name"  => "Arial, Helvetica"
		],
		self::FAMILY_ARIAL_BLACK   => [
			"class" => "font-family-arial-black",
			"name"  => "Arial Black, Gadget"
		],
		self::FAMILY_COMIC_SANS_MS => [
			"class" => "font-family-comic-sans",
			"name"  => "Comic Sans MS"
		],
		self::FAMILY_COURIER_NEW   => [
			"class" => "font-family-courier-new",
			"name"  => "Courier New"
		],
		self::FAMILY_GEORGIA       => [
			"class" => "font-family-georgia",
			"name"  => "Georgia"
		],
		self::FAMILY_IMPACT        => [
			"class" => "font-family-impact",
			"name"  => "Impact, Charcoal"
		],
		self::FAMILY_MONACO        => [
			"class" => "font-family-monaco",
			"name"  => "Lucida Console, Monaco"
		],
		self::FAMILY_LUCIDA_GRANDE => [
			"class" => "font-family-lucida-grande",
			"name"  => "Lucida Sans Unicode"
		],
		self::FAMILY_PALATINO      => [
			"class" => "font-family-palatino",
			"name"  => "Palatino"
		],
		self::FAMILY_TAHOMA        => [
			"class" => "font-family-tahoma",
			"name"  => "Tahoma, Geneva"
		],
		self::FAMILY_TIMES         => [
			"class" => "font-family-times",
			"name"  => "Times New Roman, Times"
		],
		self::FAMILY_HELVETICA     => [
			"class" => "font-family-helvetica",
			"name"  => "Trebuchet MS, Helvetica"
		],
		self::FAMILY_VERDANA       => [
			"class" => "font-family-verdana",
			"name"  => "Verdana, Geneva"
		],
		self::FAMILY_GENEVA        => [
			"class" => "font-family-geneva",
			"name"  => "MS Sans Serif, Geneva"
		],
		self::FAMILY_MS_SERIF      => [
			"class" => "font-family-ms-serif",
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
		self::TEXT_DECORATION_NONE    => [
			"value" => "none",
			"label" => ""
		],
		self::TEXT_DECORATION_UNDERLINE  => [
			"value" => "underline",
			"label" => "T"
		],
		self::TEXT_DECORATION_LINE_THROUGH   => [
			"value" => "line-through",
			"label" => "T"
		],
		self::TEXT_DECORATION_OVERLINE => [
			"value" => "overline",
			"label" => "T"
		],
	];

	/**
	 * List of text transform types
	 *
	 * @var array
	 */
	public static $textTransformList = [
		self::TEXT_TRANSFORM_NONE    => [
			"value" => "none",
			"label" => ""
		],
		self::TEXT_TRANSFORM_UPPERCASE  => [
			"value" => "uppercase",
			"label" => "AA"
		],
		self::TEXT_TRANSFORM_LOWERCASE   => [
			"value" => "lowercase",
			"label" => "aa"
		],
		self::TEXT_TRANSFORM_CAPITALIZE => [
			"value" => "capitalize",
			"label" => "Aa"
		],
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function tableName()
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
	 * Rules
	 *
	 * @return array
	 */
	public function rules()
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
			"family"     => [
				"name"  => str_replace(self::REPLACE_VALUE, "family", $name),
				"value" => $this->family
			],
			"size"       => [
				"name"  => str_replace(self::REPLACE_VALUE, "size", $name),
				"value" => $this->size
			],
			"color"           => [
				"name"  => str_replace(self::REPLACE_VALUE, "color", $name),
				"value" => $this->color
			],
			"is_italic"      => [
				"name"  => str_replace(self::REPLACE_VALUE, "is_italic", $name),
				"value" => $this->is_italic
			],
			"is_bold"     => [
				"name"  => str_replace(self::REPLACE_VALUE, "is_bold", $name),
				"value" => $this->is_bold
			],
			"align"      => [
				"name"  => str_replace(self::REPLACE_VALUE, "align", $name),
				"value" => $this->align
			],
			"decoration" => [
				"name"  => str_replace(self::REPLACE_VALUE, "decoration", $name),
				"value" => $this->decoration
			],
			"transform"  => [
				"name"  => str_replace(self::REPLACE_VALUE, "transform", $name),
				"value" => $this->transform
			],
			"letter_spacing"  => [
				"name"  => str_replace(self::REPLACE_VALUE, "letter_spacing", $name),
				"value" => $this->letter_spacing
			],
			"line_height"     => [
				"name"  => str_replace(self::REPLACE_VALUE, "line_height", $name),
				"value" => $this->line_height
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