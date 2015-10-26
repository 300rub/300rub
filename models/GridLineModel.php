<?php

namespace models;

use system\base\Model;

/**
 * Class GridLineModel
 *
 * @package models
 *
 * @method GridLineModel with($array)
 * @method GridLineModel findAll
 * @method GridLineModel byId($id)
 */
class GridLineModel extends Model
{

	/**
	 * @var int
	 */
	public $section_id;

	/**
	 * @var int
	 */
	public $sort;

	/**
	 * @var int
	 */
	public $outside_design_id;

	/**
	 * @var int
	 */
	public $inside_design_id;

	/**
	 * @var DesignBlockModel
	 */
	public $outsideDesignModel;

	/**
	 * @var DesignBlockModel
	 */
	public $insideDesignModel;

	/**
	 * @return string
	 */
	public function tableName()
	{
		return "grid_lines";
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return [
			"outsideDesignModel" => ['models\DesignBlockModel', "outside_design_id"],
			"insideDesignModel" => ['models\DesignBlockModel', "inside_design_id"]
		];
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			"section_id"        => ["required"],
			"sort"              => ["required"],
			"outside_design_id" => ["required"],
			"inside_design_id"  => ["required"],
		];
	}

	/**
	 * @return array
	 */
	public function labels()
	{
		return [];
	}

	/**
	 * @param string $className
	 *
	 * @return GridLineModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

	/**
	 * @param int $sectionId
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
	 * @return GridLineModel
	 */
	public function ordered()
	{
		$this->db->order = "t.sort";
		return $this;
	}
}