<?php

namespace models;

use components\Db;
use components\Exception;
use components\Language;

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
	public $is_editor = false;

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
	public $design_text_id;

	/**
	 * ID of DesignTextModel
	 *
	 * @var int
	 */
	public $design_block_id;

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
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"designTextModel"  => ['models\DesignTextModel', "design_text_id"],
		"designBlockModel" => ['models\DesignBlockModel', "design_block_id"]
	];

	/**
	 * Fields for duplicate
	 *
	 * @var string[]
	 */
	public $fieldsForDuplicate = [
		"name",
		"language",
		"type",
		"is_editor",
		"text"
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
			"is_editor"       => [],
			"type"            => [],
			"text"            => [],
			"design_text_id"  => [],
			"design_block_id" => [],
			"name"            => ["required"],
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
	 * Gets design forms
	 *
	 * @return array
	 */
	public function getDesignForms()
	{
		$list = [];
		$forms = [];

		if (!$this->is_editor) {
			$forms[] = [
				"id"     => $this->designTextModel->id,
				"type"   => "text",
				"values" => $this->designTextModel->getValues("designTextModel.%s"),
			];
		}
		$forms[] = [
			"id"     => $this->designBlockModel->id,
			"type"   => "block",
			"values" => $this->designBlockModel->getValues("designBlockModel.%s"),
		];

		$list[] = [
			"title" => Language::t("text", "text"),
			"forms" => $forms
		];

		return $list;
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
	private function _setValues()
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

		$this->is_editor = intval(boolval(intval($this->is_editor)));
	}

	/**
	 * Runs after finding model
	 *
	 * @return AbstractModel
	 */
	protected function afterFind()
	{
		parent::afterFind();

		$this->_setValues();
	}

	/**
	 * Runs before save
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		$this->_setValues();

		$this->design_text_id = intval($this->design_text_id);
		if (!$this->designTextModel instanceof DesignTextModel) {
			if ($this->design_text_id === 0) {
				$this->designTextModel = new DesignTextModel();
			} else {
				$this->designTextModel = DesignTextModel::model()->byId($this->design_text_id)->find();
				if ($this->designTextModel === null) {
					$this->designTextModel = new DesignTextModel();
				}
			}
		}

		$this->design_block_id = intval($this->design_block_id);
		if (!$this->designBlockModel instanceof DesignBlockModel) {
			if ($this->design_block_id === 0) {
				$this->designBlockModel = new DesignBlockModel();
			} else {
				$this->designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
				if ($this->designBlockModel === null) {
					$this->designBlockModel = new DesignBlockModel();
				}
			}
		}

		return parent::beforeSave();
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->name = strip_tags($this->name);
	}

	/**
	 * Duplicates section
	 * If success returns ID of new section
	 *
	 * @return int
	 */
	public function duplicate()
	{
		Db::startTransaction();

		try {
			$modelForCopy = $this->withAll()->byId($this->id)->find();

			$designTextModel = clone $modelForCopy->designTextModel;
			$designTextModel->id = null;
			if (!$designTextModel->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}

			$designBlockModel = clone $modelForCopy->designBlockModel;
			$designBlockModel->id = null;
			if (!$designBlockModel->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}

			$model = clone $modelForCopy;
			$model->id = null;
			$model->designTextModel = $designTextModel;
			$model->designBlockModel = $designBlockModel;
			$model->design_text_id = $designTextModel->id;
			$model->design_block_id = $designBlockModel->id;

			if (!$model->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}

			Db::commitTransaction();
			return intval($model->id);
		} catch (Exception $e) {
			Db::rollbackTransaction();
			return 0;
		}
	}
}