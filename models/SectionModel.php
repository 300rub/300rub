<?php

namespace models;

use system\db\Db;
use system\web\Language;
use system\base\Model;

/**
 * Файл класса SectionModel
 *
 * @package models
 *
 * @method SectionModel   byId($id)
 * @method SectionModel   find
 * @method SectionModel[] findAll
 * @method SectionModel   with($relations)
 * @method SectionModel   exceptId($id)
 * @method SectionModel   withAll
 */
class SectionModel extends Model
{

	/**
	 * Стандартная ширина
	 */
	const DEFAULT_WIDTH = 980;

	/**
	 * Идннтификатор раздела
	 *
	 * @var int
	 */
	public $seo_id = 0;

	/**
	 * Идентификатор языка
	 *
	 * @var int
	 */
	public $language = 0;

	/**
	 * Ширина
	 *
	 * @var int
	 */
	public $width = 0;

	/**
	 * Является ли раздел главным
	 *
	 * @var bool
	 */
	public $is_main = false;

	/**
	 * @var int
	 */
	public $design_block_id;

	/**
	 * @var SeoModel
	 */
	public $seoModel = null;

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
		"is_main"  => "checkbox",
		"width"    => "field",
	];

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "sections";
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
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
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return [
			"is_main" => Language::t("common", "сделать главным"),
			"width"   => Language::t("common", "Ширина"),
		];
	}

	/**
	 * Возвращает связи между объектами
	 *
	 * @return array
	 */
	public function relations()
	{
		return [
			"seoModel"         => ['models\SeoModel', "seo_id"],
			"designBlockModel" => ['models\DesignBlockModel', "design_block_id"]
		];
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return SectionModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

	/**
	 * Поиск по url
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

	public function selectMain()
	{
		$this->db->addCondition("t.is_main = 1");
		return $this;
	}

	/**
	 * Добавляет в условия выбора сортировку по названию
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
	 * Выполняется перед валидацией модели
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
	 * Выполняется перед сохранением модели
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

		return parent::beforeSave();
	}

	/**
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

	public function duplicate()
	{
		Db::startTransaction();

		$seoId = $this->seoModel->duplicate(false);
		if (!$seoId) {
			Db::rollbackTransaction();
			return false;
		}

		$designBlockModel = clone $this->designBlockModel;
		$designBlockModel->id = null;
		if (!$designBlockModel->save(false)) {
			Db::rollbackTransaction();
			return false;
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
			return false;
		}

		$gridLines = GridLineModel::model()->bySectionId($this->id)->withAll()->findAll();
		foreach ($gridLines as $gridLine) {
			$outsideDesignModel = clone $gridLine->outsideDesignModel;
			$outsideDesignModel->id = null;
			if (!$outsideDesignModel->save(false)) {
				Db::rollbackTransaction();
				return false;
			}
			$insideDesignModel = clone $gridLine->insideDesignModel;
			$insideDesignModel->id = null;
			if (!$insideDesignModel->save(false)) {
				Db::rollbackTransaction();
				return false;
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
				return false;
			}
			$grids = GridModel::model()->byLineId($gridLine->id)->findAll();
			foreach ($grids as $grid) {
				$newGrid = clone $grid;
				$newGrid->id = null;
				$newGrid->grid_line_id = $line->id;
				if (!$newGrid->save(false)) {
					Db::rollbackTransaction();
					return false;
				}
			}
		}

		Db::commitTransaction();
		return $model->id;
	}

	/**
	 * @return array
	 */
	public function getDesignForms()
	{
		$list = [];

		$list[] = [
			"title" => Language::t("common", "Background"),
			"forms" => [
				[
					"id"     => $this->designBlockModel->id,
					"type"   => "block",
					"values" => $this->designBlockModel->getValues("designBlockModel][t")
				]
			]
		];

		$lines = GridLineModel::model()
			->ordered()
			->bySectionId($this->id)
			->with(["outsideDesignModel", "insideDesignModel"])
			->findAll();
		foreach ($lines as $line) {
			$list[] = [
				"title" => Language::t("common", "Линия {$line->sort}"),
				"forms" => [
					[
						"id"     => $line->outsideDesignModel->id,
						"type"   => "block",
						"values" => $line->outsideDesignModel->getValues("lines][{$line->id}][outsideDesignModel"),
					]
				]
			];

			$list[] = [
				"title" => Language::t("common", "Линия {$line->sort} контейнер"),
				"forms" => [
					[
						"id"     => $line->insideDesignModel->id,
						"type"   => "block",
						"values" => $line->insideDesignModel->getValues("lines][{$line->id}][insideDesignModel"),
					]
				]
			];
		}

		return $list;
	}

	/**
	 * @param array $data
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