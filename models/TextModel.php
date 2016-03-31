<?php

namespace models;

use system\web\Language;
use system\base\Model;

/**
 * Model for working with table "texts"
 *
 * @package models
 *
 * @method TextModel[] findAll
 * @method TextModel ordered
 */
class TextModel extends Model
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
}