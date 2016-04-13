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
		if (!$this->is_main && !$this->selectMain()->find()) {
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
			$this->width = 0;
		} {
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
			if (!$gridLineModel->delete(false)) {
				return false;
			}
		}

		$seoModel = $this->seoModel;
		if ($seoModel === null) {
			$seoModel = SeoModel::model()->byId($this->seo_id)->find();
		}
		if ($seoModel instanceof SeoModel) {
			$seoModel->delete(false);
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			$designBlockModel->delete(false);
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
	 * @param bool $useTransaction Is transaction needs to be used
	 *
	 * @return SectionModel|null
	 */
	public function duplicate($useTransaction = true)
	{
		if ($useTransaction === true) {
			Db::startTransaction();
		}

		try {
			$modelForCopy = $this->withAll()->byId($this->id)->find();

			$seoModel = $modelForCopy->seoModel->duplicate(false);
			if ($seoModel === null) {
				if ($useTransaction === true) {
					Db::rollbackTransaction();
				}
				return null;
			}

			$designBlockModel = $modelForCopy->designBlockModel->duplicate();
			if ($designBlockModel === null) {
				if ($useTransaction === true) {
					Db::rollbackTransaction();
				}
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
			if (!$model->save(false)) {
				if ($useTransaction === true) {
					Db::rollbackTransaction();
				}
				return null;
			}

			$gridLines = GridLineModel::model()->bySectionId($modelForCopy->id)->withAll()->findAll();
			foreach ($gridLines as $gridLine) {
				if ($gridLine->duplicate($model->id) === null) {
					if ($useTransaction === true) {
						Db::rollbackTransaction();
					}
					return null;
				}
			}

			if ($useTransaction === true) {
				Db::commitTransaction();
			}
			return $model;
		} catch (Exception $e) {
			if ($useTransaction === true) {
				Db::rollbackTransaction();
			}
			return null;
		}
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
}