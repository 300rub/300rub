<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "texts"
 *
 * @package models
 *
 * @method TextModel[] findAll
 * @method TextModel ordered
 * @method TextModel byId($id)
 * @method TextModel find
 * @method TextModel withAll
 */
class TextModel extends AbstractModel
{

	/**
	 * Type. <div>
	 */
	const TYPE_DIV = 0;

	/**
	 * Type. <h1>
	 */
	const TYPE_H1 = 1;

	/**
	 * Type. <h2>
	 */
	const TYPE_H2 = 2;

	/**
	 * Type. <h3>
	 */
	const TYPE_H3 = 3;

	/**
	 * Type. <adress>
	 */
	const TYPE_ADRESS = 4;

	/**
	 * Type. <mark>
	 */
	const TYPE_MARK = 5;

	/**
	 * Block's name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Language ID
	 *
	 * @var integer
	 */
	public $language;

	/**
	 * Is editor used
	 *
	 * @var boolean
	 */
	public $isEditor = false;

	/**
	 * Text type
	 *
	 * @var int
	 */
	public $type = 0;

	/**
	 * Text
	 *
	 * @var string
	 */
	public $text = "";

	/**
	 * ID of DesignTextModel
	 *
	 * @var int
	 */
	public $designTextId;

	/**
	 * ID of DesignTextModel
	 *
	 * @var int
	 */
	public $designBlockId;

	/**
	 * Design text model
	 *
	 * @var DesignTextModel
	 */
	public $designTextModel;

	/**
	 * Design block model
	 *
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * List of tag type values
	 *
	 * @var array
	 */
	public static $typeTagList = [
		self::TYPE_DIV    => "div",
		self::TYPE_H1     => "h1",
		self::TYPE_H2     => "h2",
		self::TYPE_H3     => "h3",
		self::TYPE_ADRESS => "adress",
		self::TYPE_MARK   => "mark",
	];

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"name"      => self::FORM_TYPE_FIELD,
		"isEditor" => self::FORM_TYPE_CHECKBOX,
		"type"      => self::FORM_TYPE_SELECT
	];

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"designTextModel"  => ['models\DesignTextModel', "designTextId"],
		"designBlockModel" => ['models\DesignBlockModel', "designBlockId"]
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "texts";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"name"            => ["required", "max" => 255],
			"language"        => [],
			"isEditor"       => [],
			"type"            => [],
			"text"            => [],
			"designTextId"  => [],
			"designBlockId" => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return TextModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Gets type list
	 *
	 * @return array
	 */
	public static function getTypeList()
	{
		return [
			self::TYPE_DIV    => Language::t("text", "typeDefault"),
			self::TYPE_H1     => Language::t("text", "typeH1"),
			self::TYPE_H2     => Language::t("text", "typeH2"),
			self::TYPE_H3     => Language::t("text", "typeH3"),
			self::TYPE_ADRESS => Language::t("text", "typeAddress"),
			self::TYPE_MARK   => Language::t("text", "typeImportant"),
		];
	}

	/**
	 * Gets tag name
	 *
	 * @return string
	 */
	public function getTag()
	{
		if (array_key_exists($this->type, self::$typeTagList)) {
			return self::$typeTagList[$this->type];
		}

		return self::$typeTagList[self::TYPE_DIV];
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->language = intval($this->language);
		if (
			$this->language === 0
			|| !array_key_exists($this->language, Language::$aliasList)
		) {
			$this->language = Language::$activeId;
		}

		$this->type = intval($this->type);
		if (!array_key_exists($this->type, self::$typeTagList)) {
			$this->type = self::TYPE_DIV;
		}

		$this->isEditor = boolval($this->isEditor);
		$this->designTextId = intval($this->designTextId);
		$this->designBlockId = intval($this->designBlockId);
	}

	/**
	 * Runs before save
	 */
	protected function beforeSave()
	{
		$this->isEditor = intval($this->isEditor);
		if ($this->isEditor >= 1) {
			$this->isEditor = 1;
		} else {
			$this->isEditor = 0;
		}

		if (!$this->designTextModel instanceof DesignTextModel) {
			if ($this->designTextId === 0) {
				$this->designTextModel = new DesignTextModel();
			} else {
				$this->designTextModel = DesignTextModel::model()->byId($this->designTextId)->find();
				if ($this->designTextModel === null) {
					$this->designTextModel = new DesignTextModel();
				}
			}
		}

		if (!$this->designBlockModel instanceof DesignBlockModel) {
			if ($this->designBlockId === 0) {
				$this->designBlockModel = new DesignBlockModel();
			} else {
				$this->designBlockModel = DesignBlockModel::model()->byId($this->designBlockId)->find();
				if ($this->designBlockModel === null) {
					$this->designBlockModel = new DesignBlockModel();
				}
			}
		}

		parent::beforeSave();
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->name = trim(strip_tags($this->name));
	}

	/**
	 * Duplicates text
	 * If success returns ID of new text
	 *
	 * @return TextModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate()
	{
		$modelForCopy = $this->withAll()->byId($this->id)->find();

		$designTextModel = $modelForCopy->designTextModel->duplicate();
		$designBlockModel = $modelForCopy->designBlockModel->duplicate();

		$model = clone $this;
		$model->name = Language::t("common", "copy") . " {$this->name}";
		$model->id = 0;
		$model->text = "";
		$model->designTextModel = $designTextModel;
		$model->designTextId = $designTextModel->id;
		$model->designBlockModel = $designBlockModel;
		$model->designBlockId = $designBlockModel->id;
		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate TextModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}
		
		return $model;
	}

	/**
	 * Runs before delete
	 *
	 * @throws ModelException
	 */
	protected function beforeDelete()
	{
		$designTextModel = $this->designTextModel;
		if ($designTextModel === null) {
			$designTextModel = DesignTextModel::model()->byId($this->designTextId)->find();
		}
		if ($designTextModel instanceof DesignTextModel) {
			if (!$designTextModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignTextModel model with ID = {id}",
					[
						"id" => $designTextModel->id
					]
				);
			}
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->designBlockId)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			if (!$designBlockModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignBlockModel model with ID = {id}",
					[
						"id" => $designBlockModel->id
					]
				);
			}
		}

		parent::beforeDelete();
	}
}