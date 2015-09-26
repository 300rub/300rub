<?php

namespace models;

use system\base\Model;
use system\web\Language;

/**
 * Файл класса BlockModel
 *
 * @package models
 */
class BlockModel extends Model
{

	const TYPE_TEXT = 1;

	/**
	 * @var int
	 */
	public $type;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var int
	 */
	public $content_id;

	/**
	 * @var int
	 */
	public $language;

	/**
	 * @var array
	 */
	public static $typeList = [
		self::TYPE_TEXT => "text",
	];

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = [
		"name" => "field"
	];

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "blocks";
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
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"language"   => ["required"],
			"name"       => ["required", "max" => 255],
			"type"       => ["required"],
			"content_id" => ["required"],
		];
	}

	/**
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return [
			"name" => Language::t("common", "Название"),
		];
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return BlockModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}
}