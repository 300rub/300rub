<?php

namespace models;

use system\web\Language;
use system\base\Model;

/**
 * Файл класса TextModel
 *
 * @package models
 */
class TextModel extends Model
{

	/**
	 * Размер
	 *
	 * @var int
	 */
	public $size = 0;

	/**
	 * Использовать ли редактор
	 *
	 * @var boolean
	 */
	public $is_editor = false;

	/**
	 * Тип
	 *
	 * @var int
	 */
	public $type = 0;

	/**
	 * Текст
	 *
	 * @var string
	 */
	public $text = "";

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = [
		"size"      => "field",
		"is_editor" => "field",
		"type"      => "field",
		"text"      => "field",
	];

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "texts";
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"size"      => [],
			"is_editor" => [],
			"type"      => [],
			"text"      => [],
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
			"size"      => Language::t("common", "Размер"),
			"is_editor" => Language::t("common", "Редактор"),
			"type"      => Language::t("common", "Тип"),
			"text"      => Language::t("common", "Текст"),
		];
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
	 * @return TextModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}
}