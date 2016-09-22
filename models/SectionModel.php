<?php

namespace models;

use components\exceptions\ContentException;
use components\exceptions\ModelException;
use components\Language;

/**
 * Model for working with table "sections"
 *
 * @package models
 *
 * @method SectionModel   byId($id)
 * @method SectionModel   find()
 * @method SectionModel[] findAll
 * @method SectionModel   with($relations)
 * @method SectionModel   exceptId($id)
 * @method SectionModel   withAll()
 */
class SectionModel extends AbstractModel
{

	/**
	 * Default page with in px
	 */
	const DEFAULT_WIDTH = 980;

	/**
	 * ID of SeoModel
	 *
	 * @var int
	 */
	public $seoId = 0;

	/**
	 * ID of language
	 *
	 * @var int
	 */
	public $language = 0;

	/**
	 * Width in px
	 *
	 * @var int
	 */
	public $width = self::DEFAULT_WIDTH;

	/**
	 * Is this section main
	 *
	 * @var bool
	 */
	public $isMain = false;

	/**
	 * ID of DesignBlockModel
	 *
	 * @var int
	 */
	public $designBlockId = 0;

	/**
	 * Seo model
	 *
	 * @var SeoModel
	 */
	public $seoModel = null;

	/**
	 * Design block model
	 *
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"seoModel"         => ['models\SeoModel', "seoId"],
		"designBlockModel" => ['models\DesignBlockModel', "designBlockId"]
	];

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"width"   => self::FORM_TYPE_FIELD,
		"isMain" => self::FORM_TYPE_CHECKBOX
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "sections";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"seoId"          => [],
			"language"        => [],
			"width"           => [],
			"isMain"         => [],
			"designBlockId" => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return SectionModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Adds url & language condition in SQL request
	 *
	 * @param string $url url раздела
	 *
	 * @return SectionModel
	 */
	public function byUrl($url = "")
	{
		$this->db->with[] = "seoModel";
		$this->db->addCondition("t.language = :language");
		$this->db->params["language"] = Language::$activeId;

		if ($url) {
			$this->db->addCondition("seoModel.url = :url");
			$this->db->params["url"] = $url;
		} else {
			$this->selectMain();
		}

		return $this;
	}

	/**
	 * Adds isMain condition in SQL request
	 *
	 * @return SectionModel
	 */
	public function selectMain()
	{
		$this->db->addCondition("t.isMain = 1");
		return $this;
	}

	/**
	 * Adds sort by seo.url in SQL request
	 *
	 * @return SectionModel
	 */
	public function ordered()
	{
		$this->db->with[] = "seoModel";
		$this->db->order = "seoModel.url";

		return $this;
	}

	/**
	 * Runs before save
	 */
	protected function beforeSave()
	{
		if ($this->isMain === 1) {
			$this->updateForAll(["isMain" => 0]);
		}
		if ($this->isMain === 0 && !$this->selectMain()->exceptId($this->id)->find()) {
			$this->isMain = 1;
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
	 * Sets values
	 */
	protected function setValues()
	{
		$this->seoId = intval($this->seoId);

		$this->language = intval($this->language);
		if (!array_key_exists($this->language, Language::$aliasList)) {
			$this->language = Language::$activeId;
		}

		$this->width = intval($this->width);
		if ($this->width <= 0) {
			$this->width = self::DEFAULT_WIDTH;
		}

		$this->isMain = intval($this->isMain);
		if ($this->isMain < 0) {
			$this->isMain = 0;
		} else if ($this->isMain > 1) {
			$this->isMain = 1;
		}

		$this->designBlockId = intval($this->designBlockId);
	}

	/**
	 * Gets width
	 *
	 * @return string
	 */
	public function getWidth()
	{
		if ($this->width <= 100) {
			return "{$this->width}%";
		}
		return "{$this->width}px";
	}

	/**
	 * Runs before delete
	 *
	 * @throws ModelException
	 */
	protected function beforeDelete()
	{
		$gridLineModels = GridLineModel::model()->bySectionId($this->id)->withAll()->findAll();
		foreach ($gridLineModels as $gridLineModel) {
			if (!$gridLineModel->delete()) {
				throw new ModelException(
					"Unable to delete GridLineModel model with ID = {id}",
					[
						"id" => $gridLineModel->id
					]
				);
			}
		}

		$seoModel = $this->seoModel;
		if ($seoModel === null) {
			$seoModel = SeoModel::model()->byId($this->seoId)->find();
		}
		if ($seoModel instanceof SeoModel) {
			if (!$seoModel->delete()) {
				throw new ModelException(
					"Unable to delete SeoModel model with ID = {id}",
					[
						"id" => $seoModel->id
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

		if ($this->isMain) {
			$model = self::model()->exceptId($this->id)->find();
			if ($model) {
				$model->isMain = 1;
				if (!$model->save()) {
					throw new ModelException(
						"Unable to update section for isMain = 1 for ID = {id}",
						[
							"id" => $model->id
						]
					);
				}
			}
		}

		parent::beforeDelete();
	}

	/**
	 * Duplicates section
	 * If success returns ID of new section
	 *
	 * @return SectionModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate()
	{
		$modelForCopy = $this->withAll()->byId($this->id)->find();

		$seoModel = $modelForCopy->seoModel->duplicate();
		$designBlockModel = $modelForCopy->designBlockModel->duplicate();

		$model = new SectionModel();
		$model->seoModel = $seoModel;
		$model->seoId = $seoModel->id;
		$model->language = $modelForCopy->language;
		$model->width = $modelForCopy->width;
		$model->isMain = 0;
		$model->designBlockModel = $designBlockModel;
		$model->designBlockId = $designBlockModel->id;
		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate SectionModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}

		$gridLines = GridLineModel::model()->bySectionId($modelForCopy->id)->withAll()->findAll();
		foreach ($gridLines as $gridLine) {
			$gridLine->duplicate($model->id);
		}

		return $model;
	}

	/**
	 * Saves design
	 *
	 * @param array $data Data
	 * 
	 * @throws ContentException
	 * @throws ModelException
	 */
	public function saveDesign($data)
	{
		if (!isset($data["designBlockModel"])) {
			throw new ContentException("Unable to find designBlockModel in content");
		}

		$this->designBlockModel->setAttributes($data["designBlockModel"]);
		if (!$this->designBlockModel->save()) {
			throw new ModelException("Unable to save DesignBlockModel");
		}

		foreach ($data["lines"] as $id => $values) {
			$gridLineModel = GridLineModel::model()
				->with(["outsideDesignModel", "insideDesignModel"])
				->byId($id)
				->find();
			if (!$gridLineModel) {
				throw new ModelException(
					"Unable to find GridLineModel by ID = {id}",
					[
						"id" => $id
					]
				);
			}
			$gridLineModel->setAttributes($values);
			if (!$gridLineModel->save()) {
				throw new ModelException(
					"Unable to save GridLineModel with ID = {id}",
					[
						"id" => $gridLineModel->id
					]
				);
			}
		}
	}
}