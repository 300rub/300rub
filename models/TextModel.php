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
		"is_editor" => "checkbox",
		"type"      => "select",
		"name"      => "field",
		"text"      => "text",
	];

	const TYPE_DIV = 0;
	const TYPE_H1 = 1;
	const TYPE_H2 = 2;
	const TYPE_H3 = 3;
	const TYPE_ADRESS = 4;
	const TYPE_MARK = 5;
	const TYPE_CODE = 6;

	/**
	 * @var array
	 */
	public static $typeTagList = [
		self::TYPE_DIV    => "div",
		self::TYPE_H1     => "h1",
		self::TYPE_H2     => "h2",
		self::TYPE_H3     => "h3",
		self::TYPE_ADRESS => "adress",
		self::TYPE_MARK   => "mark",
		self::TYPE_CODE   => "code",
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
			"name"            => ["required"],
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
		$list = [];
		if (!$this->is_editor) {
			$list[] = [
				"id"     => $this->designTextModel->id,
				"type"   => "text",
				"title"  => Language::t("common", "Текст"),
				"values" => $this->designTextModel->getValues("designTextModel"),
			];
		}
		$list[] = [
			"id"     => $this->designBlockModel->id,
			"type"   => "block",
			"title"  => Language::t("common", "Блок"),
			"values" => $this->designBlockModel->getValues("designBlockModel"),
		];

		return $list;
	}

	/**
	 * @return array
	 */
	public function getTypeList()
	{
		return [
			self::TYPE_DIV    => Language::t("common", "По умолчанию"),
			self::TYPE_H1     => Language::t("common", "Заголовок 1 уровня"),
			self::TYPE_H2     => Language::t("common", "Заголовок 2 уровня"),
			self::TYPE_H3     => Language::t("common", "Заголовок 3 уровня"),
			self::TYPE_ADRESS => Language::t("common", "Адрес"),
			self::TYPE_MARK   => Language::t("common", "Важный текст"),
			self::TYPE_CODE   => Language::t("common", "Код"),
		];
	}

	/**
	 * @return string
	 */
	public function getTag()
	{
		if (array_key_exists($this->type, self::$typeTagList)) {
			return self::$typeTagList[$this->type];
		}

		return self::$typeTagList[self::TYPE_DIV];
	}
}