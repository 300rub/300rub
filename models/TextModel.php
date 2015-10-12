<?php

namespace models;

use system\web\Language;
use system\base\Model;

/**
 * Файл класса TextModel
 *
 * @package models
 *
 * @method TextModel[] findAll
 */
class TextModel extends Model
{

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var integer
	 */
	public $language;

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
	 * @var int
	 */
	public $design_text_id;

	/**
	 * @var int
	 */
	public $design_block_id;

	/**
	 * @var DesignTextModel
	 */
	public $designTextModel;

	/**
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = [
		"is_editor" => "field",
		"type"      => "field",
		"text"      => "field",
		"name"      => "field",
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
			"is_editor"       => [],
			"type"            => [],
			"text"            => [],
			"design_text_id"  => [],
			"design_block_id" => [],
			"name"            => [],
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
			"is_editor" => Language::t("common", "Редактор"),
			"type"      => Language::t("common", "Тип"),
			"text"      => Language::t("common", "Текст"),
			"name"      => Language::t("common", "Название"),
		];
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return [
			"designTextModel"  => ['models\DesignTextModel', "design_text_id"],
			"designBlockModel" => ['models\DesignBlockModel', "design_block_id"]
		];
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

	/**
	 * @return array
	 */
	public function getDesignForms()
	{
		return [
			[
				"id"     => $this->designTextModel->id,
				"type"   => "text",
				"title"  => Language::t("common", "Текст"),
				"values" => $this->designTextModel->getValues("designTextModel"),
			],
			[
				"id"     => $this->designBlockModel->id,
				"type"   => "block",
				"title"  => Language::t("common", "Блок"),
				"values" => $this->designBlockModel->getValues("designBlockModel"),
			]
		];
	}
}