<?php

namespace models;

use system\base\Exception;
use system\base\Model;
use system\web\Language;

/**
 * Файл класса BlockModel
 *
 * @package models
 *
 * @method BlockModel[] findAll
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

	/**
	 * @return BlockModel
	 */
	public function ordered()
	{
		$this->db->order = "t.name";
		return $this;
	}

	/**
	 * @return array
	 */
	public static function getTypesList()
	{
		return [
			self::TYPE_TEXT => [
				"name"  => Language::t("common", "Текст"),
				"class" => "text",
				"with" => ["designTextModel"]
			]
		];
	}

	/**
	 * @return array
	 */
	public function getAllBlocksForGridWindow()
	{
		$list = [];
		$typesList = self::getTypesList();

		foreach ($typesList as $key => $value) {
			$list[$key] = [
				"name"   => $value["name"],
				"class"  => $value["class"],
				"blocks" => []
			];
		}

		$blocks = $this->ordered()->findAll();
		foreach ($blocks as $block) {
			$list[$block->type]["blocks"][$block->id] = $block->name;
		}

		return $list;
	}

	/**
	 * @return Model
	 *
	 * @throws Exception
	 */
	public function getContentModel()
	{
		$typeList = self::getTypesList();

		if (!array_key_exists($this->type, $typeList)) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$modelName = '\\models\\' . ucfirst($typeList[$this->type]["class"]) . 'Model';
		/**
		 * @var Model $model
		 */
		$model = $modelName::model()->byId($this->content_id)->withAll()->find();

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		return $model;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function getContentView()
	{
		$typeList = self::getTypesList();

		if (!array_key_exists($this->type, $typeList)) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		return '/'. $typeList[$this->type]["class"] .'/content';
	}
}