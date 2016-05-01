<?php

namespace models;

use components\Exception;
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
	public $seo_id = 0;

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
	public $width = 0;

	/**
	 * Is this section main
	 *
	 * @var bool
	 */
	public $is_main = false;

	/**
	 * ID of DesignBlockModel
	 *
	 * @var int
	 */
	public $design_block_id;

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
		"seoModel"         => ['models\SeoModel', "seo_id"],
		"designBlockModel" => ['models\DesignBlockModel', "design_block_id"]
	];

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"width"   => self::FORM_TYPE_FIELD,
		"is_main" => self::FORM_TYPE_CHECKBOX
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
			"seo_id"          => [],
			"language"        => [],
			"width"           => [],
			"is_main"         => [],
			"design_block_id" => [],
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
	 * Adds is_main condition in SQL request
	 *
	 * @return SectionModel
	 */
	public function selectMain()
	{
		$this->db->addCondition("t.is_main = 1");
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
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		$this->_setValues();

		if ($this->is_main === 1 && !$this->updateForAll(["is_main" => 0])) {
			return false;
		}
		if ($this->is_main === 0 && !$this->selectMain()->exceptId($this->id)->find()) {
			$this->is_main = 1;
		}

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
	 * Sets values
	 */
	private function _setValues()
	{
		$this->seo_id = intval($this->seo_id);

		$this->language = intval($this->language);
		if (!array_key_exists($this->language, Language::$aliasList)) {
			$this->language = Language::$activeId;
		}

		$this->width = intval($this->width);
		if ($this->width <= 0) {
			$this->width = self::DEFAULT_WIDTH;
		}

		$this->is_main = intval($this->is_main);
		if ($this->is_main < 0) {
			$this->is_main = 0;
		} else if ($this->is_main > 1) {
			$this->is_main = 1;
		}

		$this->design_block_id = intval($this->design_block_id);
	}

	/**
	 * Runs after finding model
	 *
	 * @return void
	 */
	protected function afterFind()
	{
		parent::afterFind();

		$this->_setValues();
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
	 * @return bool
	 */
	protected function beforeDelete()
	{
		$gridLineModels = GridLineModel::model()->bySectionId($this->id)->withAll()->findAll();
		foreach ($gridLineModels as $gridLineModel) {
			if (!$gridLineModel->delete()) {
				return false;
			}
		}

		$seoModel = $this->seoModel;
		if ($seoModel === null) {
			$seoModel = SeoModel::model()->byId($this->seo_id)->find();
		}
		if ($seoModel instanceof SeoModel) {
			$seoModel->delete();
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			$designBlockModel->delete();
		}

		if ($this->is_main) {
			$model = self::model()->exceptId($this->id)->find();
			if ($model) {
				$model->is_main = 1;
				if (!$model->save()) {
					return false;
				}
			}
		}

		return parent::beforeDelete();
	}

	/**
	 * Duplicates section
	 * If success returns ID of new section
	 *
	 * @return SectionModel|null
	 */
	public function duplicate()
	{
		try {
			$modelForCopy = $this->withAll()->byId($this->id)->find();

			$seoModel = $modelForCopy->seoModel->duplicate(false);
			if ($seoModel === null) {
				return null;
			}

			$designBlockModel = $modelForCopy->designBlockModel->duplicate();
			if ($designBlockModel === null) {
				return null;
			}

			$model = new SectionModel();
			$model->seoModel = $seoModel;
			$model->seo_id = $seoModel->id;
			$model->language = $modelForCopy->language;
			$model->width = $modelForCopy->width;
			$model->is_main = 0;
			$model->designBlockModel = $designBlockModel;
			$model->design_block_id = $designBlockModel->id;
			if (!$model->save()) {
				return null;
			}

			$gridLines = GridLineModel::model()->bySectionId($modelForCopy->id)->withAll()->findAll();
			foreach ($gridLines as $gridLine) {
				if ($gridLine->duplicate($model->id) === null) {
					return null;
				}
			}

			return $model;
		} catch (Exception $e) {
			return null;
		}
	}

	/**
	 * Saves design
	 *
	 * @param array $data Data
	 *
	 * @return bool
	 */
	public function saveDesign($data)
	{
		if (!isset($data["designBlockModel"]))

		$this->designBlockModel->setAttributes($data["designBlockModel"]);
		if (!$this->designBlockModel->save()) {
			return false;
		}

		foreach ($data["lines"] as $id => $values) {
			$gridLineModel = GridLineModel::model()
				->with(["outsideDesignModel", "insideDesignModel"])
				->byId($id)
				->find();
			if (!$gridLineModel) {
				return false;
			}
			$gridLineModel->setAttributes($values);
			if (!$gridLineModel->save()) {
				return false;
			}
		}

		return true;
	}
}