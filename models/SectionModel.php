<?php

namespace models;

use components\Db;
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
			"language"        => ["required"],
			"width"           => [],
			"is_main"         => [],
			"design_block_id" => ["required"],
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
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->seo_id = intval($this->seo_id);
		$this->language = intval($this->language);
		$this->width = intval($this->width);
		$this->is_main = intval($this->is_main);

		if (!$this->width) {
			$this->width = self::DEFAULT_WIDTH;
		}
	}

	/**
	 * Runs before save
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if ($this->is_main && !$this->updateForAll(["is_main" => 0])) {
			return false;
		}
		if (!$this->is_main && !$this->selectMain()->find()) {
			$this->is_main = 1;
		}

		if (!$this->design_block_id) {
			$designBlockModel = new DesignBlockModel();
			if (!$designBlockModel->save()) {
				throw new Exception("Failed to create a design");
			}
			$this->design_block_id = $designBlockModel->id;
		}

		return parent::beforeSave();
	}

	/**
	 * Gets width
	 *
	 * @return string
	 */
	public function getWidth()
	{
		if ($this->width == 0) {
			return self::DEFAULT_WIDTH . "px";
		} else if ($this->width <= 100) {
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
			if (!$gridLineModel->delete(false)) {
				return false;
			}
		}

		if ($this->is_main) {
			$model = self::model()->exceptId($this->id)->find();
			if ($model) {
				$model->is_main = 1;
				if (!$model->save(false)) {
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
	 * @return int
	 */
	public function duplicate()
	{
		Db::startTransaction();

		$seoId = $this->seoModel->duplicate(false);
		if (!$seoId) {
			Db::rollbackTransaction();
			return 0;
		}

		$designBlockModel = clone $this->designBlockModel;
		$designBlockModel->id = null;
		if (!$designBlockModel->save(false)) {
			Db::rollbackTransaction();
			return 0;
		}

		$model = clone $this;
		$model->id = null;
		$model->seoModel = null;
		$model->designBlockModel = null;
		$model->seo_id = $seoId;
		$model->design_block_id = $designBlockModel->id;
		$model->is_main = 0;
		if (!$model->save(false)) {
			Db::rollbackTransaction();
			return 0;
		}

		$gridLines = GridLineModel::model()->bySectionId($this->id)->withAll()->findAll();
		foreach ($gridLines as $gridLine) {
			$outsideDesignModel = clone $gridLine->outsideDesignModel;
			$outsideDesignModel->id = null;
			if (!$outsideDesignModel->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}
			$insideDesignModel = clone $gridLine->insideDesignModel;
			$insideDesignModel->id = null;
			if (!$insideDesignModel->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}
			$line = clone $gridLine;
			$line->id = null;
			$line->section_id = $model->id;
			$line->outsideDesignModel = null;
			$line->insideDesignModel = null;
			$line->outside_design_id = $outsideDesignModel->id;
			$line->inside_design_id = $insideDesignModel->id;
			if (!$line->save(false)) {
				Db::rollbackTransaction();
				return 0;
			}
			$grids = GridModel::model()->byLineId($gridLine->id)->findAll();
			foreach ($grids as $grid) {
				$newGrid = clone $grid;
				$newGrid->id = null;
				$newGrid->grid_line_id = $line->id;
				if (!$newGrid->save(false)) {
					Db::rollbackTransaction();
					return 0;
				}
			}
		}

		Db::commitTransaction();
		return intval($model->id);
	}

	/**
	 * Gets design forms
	 *
	 * @return array
	 */
	public function getDesignForms()
	{
		$list = [];

		$list[] = [
			"title" => Language::t("section", "background"),
			"forms" => [
				[
					"id"     => $this->designBlockModel->id,
					"type"   => "block",
					"values" => $this->designBlockModel->getValues("designBlockModel[t.%s]")
				]
			]
		];

		$lines = GridLineModel::model()
			->ordered()
			->bySectionId($this->id)
			->with(["outsideDesignModel", "insideDesignModel"])
			->findAll();
		foreach ($lines as $line) {
			$lineTitle = Language::t("section", "line") . " {$line->sort}";
			$list[] = [
				"title" => $lineTitle,
				"forms" => [
					[
						"id"     => $line->outsideDesignModel->id,
						"type"   => "block",
						"values" => $line->outsideDesignModel->getValues("lines[{$line->id}][outsideDesignModel.%s]"),
					]
				]
			];
			$list[] = [
				"title" => "{$lineTitle} " . Language::t("section", "container"),
				"forms" => [
					[
						"id"     => $line->insideDesignModel->id,
						"type"   => "block",
						"values" => $line->insideDesignModel->getValues("lines[{$line->id}][insideDesignModel.%s]"),
					]
				]
			];
		}

		return $list;
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
		Db::startTransaction();
		$this->designBlockModel->setAttributes($data["designBlockModel"]);
		if (!$this->designBlockModel->save(false)) {
			Db::rollbackTransaction();
			return false;
		}

		foreach ($data["lines"] as $id => $values) {
			$gridLineModel = GridLineModel::model()
				->with(["outsideDesignModel", "insideDesignModel"])
				->byId($id)
				->find();
			if (!$gridLineModel) {
				Db::rollbackTransaction();
				return false;
			}
			$gridLineModel->setAttributes($values);
			if (!$gridLineModel->save(false)) {
				Db::rollbackTransaction();
				return false;
			}
		}

		Db::commitTransaction();
		return true;
	}

	/**
	 * Runs after finding model
	 *
	 * @return void
	 */
	protected function afterFind()
	{
		parent::afterFind();

		if (!$this->seoModel) {
			$this->seoModel = new SeoModel();
		}

		if (!$this->language) {
			$this->language = Language::$activeId;
		}

		if (!$this->width) {
			$this->width = self::DEFAULT_WIDTH;
		}
	}
}