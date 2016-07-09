<?php

namespace models;
use components\exceptions\ModelException;

/**
 * Model for working with table "grid_lines"
 *
 * @package models
 *
 * @method GridLineModel   with($array)
 * @method GridLineModel[] findAll()
 * @method GridLineModel   byId($id)
 * @method GridLineModel   withAll()
 * @method GridLineModel   find()
 */
class GridLineModel extends AbstractModel
{

	/**
	 * Section ID
	 *
	 * @var int
	 */
	public $section_id;

	/**
	 * Sort number
	 *
	 * @var int
	 */
	public $sort;

	/**
	 * ID of DesignBlockModel for line block
	 *
	 * @var int
	 */
	public $outside_design_id;

	/**
	 * ID of DesignBlockModel for container block
	 *
	 * @var int
	 */
	public $inside_design_id;

	/**
	 * DesignBlockModel for line block
	 *
	 * @var DesignBlockModel
	 */
	public $outsideDesignModel;

	/**
	 * DesignBlockModel for container block
	 *
	 * @var DesignBlockModel
	 */
	public $insideDesignModel;

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"outsideDesignModel" => ['models\DesignBlockModel', "outside_design_id"],
		"insideDesignModel" => ['models\DesignBlockModel', "inside_design_id"]
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "grid_lines";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"section_id"        => [],
			"sort"              => [],
			"outside_design_id" => [],
			"inside_design_id"  => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return GridLineModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Adds section ID to SQL request
	 *
	 * @param int $sectionId Section ID
	 *
	 * @return GridLineModel
	 */
	public function bySectionId($sectionId = null)
	{
		if ($sectionId) {
			$this->db->addCondition("t.section_id = :section_id");
			$this->db->params["section_id"] = $sectionId;
		}

		return $this;
	}

	/**
	 * Adds order by sort to SQL request
	 *
	 * @return GridLineModel
	 */
	public function ordered()
	{
		$this->db->order = "t.sort";
		return $this;
	}

	/**
	 * Runs before deleting
	 * 
	 * @throws ModelException
	 */
	protected function beforeDelete()
	{
		$gridModels = GridModel::model()->byLineId($this->id)->findAll();
		foreach ($gridModels as $gridModel) {
			if (!$gridModel->delete()) {
				throw new ModelException(
					"Unable to delete gridModel with ID = {id}",
					[
						"id" => $gridModel->id
					]
				);
			}
		}

		$outsideDesignModel = $this->outsideDesignModel;
		if ($outsideDesignModel === null) {
			$outsideDesignModel = DesignBlockModel::model()->byId($this->outside_design_id)->find();
		}
		if ($outsideDesignModel instanceof DesignBlockModel) {
			$outsideDesignModel->delete();
		}

		$insideDesignModel = $this->insideDesignModel;
		if ($insideDesignModel === null) {
			$insideDesignModel = DesignBlockModel::model()->byId($this->inside_design_id)->find();
		}
		if ($insideDesignModel instanceof DesignBlockModel) {
			$insideDesignModel->delete();
		}

		parent::beforeDelete();
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->section_id = intval($this->section_id);
		$this->sort = intval($this->sort);
		$this->outside_design_id = intval($this->outside_design_id);
		$this->inside_design_id = intval($this->inside_design_id);
	}

	/**
	 * Runs before save
	 *
	 * @throws ModelException
	 */
	protected function beforeSave()
	{
		if ($this->section_id === 0 || SectionModel::model()->byId($this->section_id)->find() === null) {
			throw new ModelException(
				"Unable to find section by ID = {id}",
				[
					"id" => $this->section_id
				]
			);
		}

		if (!$this->outsideDesignModel instanceof DesignBlockModel) {
			if ($this->outside_design_id === 0) {
				$this->outsideDesignModel = new DesignBlockModel();
			} else {
				$this->outsideDesignModel = DesignBlockModel::model()->byId($this->outside_design_id)->find();
				if ($this->outsideDesignModel === null) {
					$this->outsideDesignModel = new DesignBlockModel();
				}
			}
		}

		if (!$this->insideDesignModel instanceof DesignBlockModel) {
			if ($this->inside_design_id === 0) {
				$this->insideDesignModel = new DesignBlockModel();
			} else {
				$this->insideDesignModel = DesignBlockModel::model()->byId($this->inside_design_id)->find();
				if ($this->insideDesignModel === null) {
					$this->insideDesignModel = new DesignBlockModel();
				}
			}
		}

		parent::beforeSave();
	}

	/**
	 * Duplicates model
	 *
	 * @param int  $sectionId  Section's ID
	 *
	 * @return GridLineModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate($sectionId)
	{
		$outsideDesignModel = $this->outsideDesignModel->duplicate();
		$insideDesignModel = $this->insideDesignModel->duplicate();

		$model = new GridLineModel();
		$model->section_id = $sectionId;
		$model->sort = $this->sort;
		$model->outsideDesignModel = $outsideDesignModel;
		$model->outside_design_id = $outsideDesignModel->id;
		$model->insideDesignModel = $insideDesignModel;
		$model->inside_design_id = $insideDesignModel->id;
		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate GridLineModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}

		$grids = GridModel::model()->byLineId($this->id)->findAll();
		foreach ($grids as $grid) {
			$grid->duplicate($model->id);
		}
		
		return $model;
	}
}