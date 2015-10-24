<?php

namespace models;

use system\base\Model;

/**
 * @package models
 */
class DesignTextModel extends Model
{

	/**
	 * @var int
	 */
	public $size;

	/**
	 * @var int
	 */
	public $family;

	/**
	 * @var string
	 */
	public $color;

	/**
	 * @var int
	 */
	public $is_italic;

	/**
	 * @var int
	 */
	public $is_bold;

	/**
	 * @var int
	 */
	public $align;

	/**
	 * @var int
	 */
	public $decoration;

	/**
	 * @var int
	 */
	public $transform;

	/**
	 * @var int
	 */
	public $letter_spacing;

	/**
	 * @var int
	 */
	public $line_height;

	const DEFAULT_LINE_HEIGHT = 140;

	const FAMILY_MYRAD = 0;
	const FAMILY_ARIAL = 1;
	const FAMILY_ARIAL_BLACK = 2;
	const FAMILY_COMIC_SANS_MS = 3;
	const FAMILY_COURIER_NEW = 4;
	const FAMILY_GEORGIA = 5;
	const FAMILY_IMPACT = 6;
	const FAMILY_MONACO = 7;
	const FAMILY_LUCIDA_GRANDE = 8;
	const FAMILY_PALATINO = 9;
	const FAMILY_TAHOMA = 10;
	const FAMILY_TIMES = 11;
	const FAMILY_HELVETICA = 12;
	const FAMILY_VERDANA = 13;
	const FAMILY_GENEVA = 14;
	const FAMILY_MS_SERIF = 15;

	/**
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
			"name"  => "Lucida Sans Unicode, Lucida Grande"
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

	const TEXT_ALIGN_LEFT = 0;
	const TEXT_ALIGN_CENTER = 1;
	const TEXT_ALIGN_RIGHT = 2;
	const TEXT_ALIGN_JUSTIFY = 3;

	/**
	 * @var array
	 */
	public static $textAlignList = [
		self::TEXT_ALIGN_LEFT    => "left",
		self::TEXT_ALIGN_CENTER  => "center",
		self::TEXT_ALIGN_RIGHT   => "right",
		self::TEXT_ALIGN_JUSTIFY => "justify",
	];

	const TEXT_DECORATION_NONE = 0;
	const TEXT_DECORATION_UNDERLINE = 1;
	const TEXT_DECORATION_LINE_THROUGH = 2;
	const TEXT_DECORATION_OVERLINE = 3;

	/**
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

	const TEXT_TRANSFORM_NONE = 0;
	const TEXT_TRANSFORM_UPPERCASE = 1;
	const TEXT_TRANSFORM_LOWERCASE = 2;
	const TEXT_TRANSFORM_CAPITALIZE = 3;

	/**
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
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "design_texts";
	}

	/**
	 * Правила валидации
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
	 * @return DesignTextModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

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
	 * @param string $name
	 *
	 * @return array
	 */
	public function getValues($name)
	{
		return [
			"family"     => [
				"name"  => "Data[{$name}.family]",
				"value" => $this->family
			],
			"size"       => [
				"name"  => "Data[{$name}.size]",
				"value" => $this->size
			],
			"color"           => [
				"name"  => "Data[{$name}.color]",
				"value" => $this->color
			],
			"is_italic"      => [
				"name"  => "Data[{$name}.is_italic]",
				"value" => $this->is_italic
			],
			"is_bold"     => [
				"name"  => "Data[{$name}.is_bold]",
				"value" => $this->is_bold
			],
			"align"      => [
				"name"  => "Data[{$name}.align]",
				"value" => $this->align
			],
			"decoration" => [
				"name"  => "Data[{$name}.decoration]",
				"value" => $this->decoration
			],
			"transform"  => [
				"name"  => "Data[{$name}.transform]",
				"value" => $this->transform
			],
			"letter_spacing"  => [
				"name"  => "Data[{$name}.letter_spacing]",
				"value" => $this->letter_spacing
			],
			"line_height"     => [
				"name"  => "Data[{$name}.line_height]",
				"value" => $this->line_height
			]
		];
	}

	/**
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