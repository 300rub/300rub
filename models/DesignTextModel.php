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

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = [];

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
			$this->line_height = 0;
		}
	}
}