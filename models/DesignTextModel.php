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
	public $style;

	/**
	 * @var int
	 */
	public $weight;

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
			"style"          => [],
			"weight"         => [],
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
		if (!$this->style) {
			$this->style = 0;
		}
		if (!$this->weight) {
			$this->weight = 0;
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