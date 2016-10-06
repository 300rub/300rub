<?php

namespace testS\models;

use testS\components\exceptions\ModelException;

/**
 * Model for working with table "designTexts"
 *
 * @package testS\models
 */
class DesignTextModel extends AbstractModel
{

	/**
	 * Min size value
	 */
	const MIN_SIZE_VALUE = 4;

	/**
	 * Min letter spacing value
	 */
	const MIN_LETTER_SPACING_VALUE = -10;

	/**
	 * Min line height value
	 */
	const MIN_LINE_HEIGHT_VALUE = 10;

	/**
	 * Value for replace
	 */
	const REPLACE_VALUE = "__";

	/**
	 * Default line-height value
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
	 * Default family
	 */
	const DEFAULT_FAMILY = self::FAMILY_MYRAD;

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
	 * Default text align
	 */
	const DEFAULT_TEXT_ALIGN = self::TEXT_ALIGN_LEFT;

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
	 * Default text decoration
	 */
	const DEFAULT_TEXT_DECORATION = self::TEXT_DECORATION_NONE;

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
	 * Default text transform
	 */
	const DEFAULT_TEXT_TRANSFORM = self::TEXT_TRANSFORM_NONE;

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
	public $isItalic;

	/**
	 * Is font-weight: bold;
	 *
	 * @var int
	 */
	public $isBold;

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
	public $letterSpacing;

	/**
	 * CSS line-height in %
	 *
	 * @var int
	 */
	public $lineHeight;

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
			"isItalic"      => [],
			"isBold"        => [],
			"align"          => [],
			"decoration"     => [],
			"transform"      => [],
			"letterSpacing" => [],
			"lineHeight"    => [],
		];
	}

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "designTexts";
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
	 * Runs before saving
	 */
	protected function beforeSave()
	{
		parent::beforeSave();

		$this->size = $this->getIntVal($this->size, self::INT_MAX_VAL, self::MIN_SIZE_VALUE);
		$this->letterSpacing = $this->getIntVal($this->letterSpacing, self::INT_MAX_VAL, self::MIN_LETTER_SPACING_VALUE);

		$this->isItalic = $this->getTinyIntVal($this->isItalic);
		$this->isBold = $this->getTinyIntVal($this->isBold);

		$this->family = intval($this->family);
		if (!array_key_exists($this->family, self::$familyList)) {
			$this->family = self::DEFAULT_FAMILY;
		}

		$this->align = intval($this->align);
		if (!array_key_exists($this->align, self::$textAlignList)) {
			$this->align = self::DEFAULT_TEXT_ALIGN;
		}

		$this->decoration = intval($this->decoration);
		if (!array_key_exists($this->decoration, self::$textDecorationList)) {
			$this->decoration = self::DEFAULT_TEXT_DECORATION;
		}

		$this->transform = intval($this->transform);
		if (!array_key_exists($this->transform, self::$textTransformList)) {
			$this->transform = self::DEFAULT_TEXT_TRANSFORM;
		}

		$this->lineHeight = intval($this->lineHeight);
		if ($this->lineHeight === 0) {
			$this->lineHeight = self::DEFAULT_LINE_HEIGHT;
		} else if ($this->lineHeight < self::MIN_LINE_HEIGHT_VALUE) {
			$this->lineHeight = self::MIN_LINE_HEIGHT_VALUE;
		}
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->size = intval($this->size);
		$this->family = intval($this->family);
		$this->letterSpacing = intval($this->letterSpacing);
		$this->align = intval($this->align);
		$this->decoration = intval($this->decoration);
		$this->transform = intval($this->transform);
		$this->lineHeight = intval($this->lineHeight);

		$this->isItalic = boolval($this->isItalic);
		$this->isBold = boolval($this->isBold);

		if (!$this->_isColor($this->color)) {
			$this->color = "";
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
					"minValue" => self::MIN_SIZE_VALUE,
					"measure"  => "px"
				],
                [
                    "name"     => sprintf($name, "letterSpacing"),
                    "value"    => $this->letterSpacing,
                    "type"     => "letter-spacing",
                    "minValue" => self::MIN_LETTER_SPACING_VALUE,
                    "measure"  => "px"
                ],
                [
                    "name"     => sprintf($name, "lineHeight"),
                    "value"    => $this->lineHeight,
                    "type"     => "line-height",
                    "minValue" => self::MIN_LINE_HEIGHT_VALUE,
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
					"name"      => sprintf($name, "isItalic"),
					"value"     => $this->isItalic,
					"type"      => "font-style",
					"checked"   => "italic",
					"unChecked" => "normal"
				],
				[
					"name"      => sprintf($name, "isBold"),
					"value"     => $this->isBold,
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
			return self::$textDecorationList[$this->decoration];
		}

		return self::$textDecorationList[self::TEXT_DECORATION_NONE];
	}

	/**
	 * Gets CSS text-transform value
	 *
	 * @return string
	 */
	public function getTextTransform()
	{
		if (array_key_exists($this->transform, self::$textTransformList)) {
			return self::$textTransformList[$this->transform];
		}

		return self::$textTransformList[self::TEXT_TRANSFORM_NONE];
	}

	/**
	 * Gets CSS font-family value
	 *
	 * @return string
	 */
	public function getFontFamilyClass()
	{
		if (
			$this->family !== self::FAMILY_MYRAD
			&& array_key_exists($this->family, self::$familyList)
		) {
			return self::$familyList[$this->family]["class"];
		}

		return "";
	}

	/**
	 * Duplicates model
	 *
	 * @return DesignTextModel
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
				"Unable to duplicate DesignTextModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}
		
		return $model;
	}
}