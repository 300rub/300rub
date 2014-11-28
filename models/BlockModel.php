<?php

namespace models;

use system\base\Model;

/**
 * Файл класса BlockModel
 *
 * @package models
 */
class BlockModel extends Model
{

	const TYPE_TEXT = 1;

	public $type;
	public $content;

	public static $typeList = array(
		self::TYPE_TEXT => "text",
	);

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "blocks";
	}

	public function relations()
	{
		return array();
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"language" => array(),
			"name"     => array(),
			"type"     => array(),
			"content"  => array(),
		);
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

	public function getType()
	{
		if (array_key_exists($this->type, self::$typeList)) {
			return self::$typeList[$this->type];
		}

		return null;
	}

	public function getContentModel()
	{
		$modelName = "models\\" . ucfirst($this->getType() . "Model");

		/**
		 * @var \system\base\Model $model
		 */
		$model = new $modelName;

		return $model->byIds($this->content)->find();
	}
}