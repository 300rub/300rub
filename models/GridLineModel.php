<?php

namespace models;

use system\base\Model;

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
class GridLineModel extends Model
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
			"section_id"        => ["required"],
			"sort"              => ["required"],
			"outside_design_id" => ["required"],
			"inside_design_id"  => ["required"],
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
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		parent::beforeValidate();

		$this->section_id = intval($this->section_id);
		$this->sort = intval($this->sort);
		$this->outside_design_id = intval($this->outside_design_id);
		$this->inside_design_id = intval($this->inside_design_id);
	}

	/**
	 * Runs before deleting
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		$gridModels = GridModel::model()->byLineId($this->id)->findAll();
		foreach ($gridModels as $gridModel) {
			if (!$gridModel->delete(false)) {
				return false;
			}
		}

		return parent::beforeDelete();
	}
}