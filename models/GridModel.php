<?php

namespace models;

use components\exceptions\ContentException;
use components\exceptions\ModelException;
use components\Language;

/**
 * Model for working with table "grids"
 *
 * @package models
 *
 * @method GridModel[] findAll()
 * @method GridModel   in($field, $values)
 * @method GridModel   with($array)
 */
class GridModel extends AbstractModel
{

	/**
	 * Grid size
	 */
	const GRID_SIZE = 12;

	/**
	 * Default width
	 */
	const DEFAULT_WIDTH = 3;

	/**
	 * Content types. Text
	 */
	const TYPE_TEXT = 1;

	/**
	 * Content types. Image
	 */
	const TYPE_IMAGE = 2;

	/**
	 * Grid line's ID
	 *
	 * @var int
	 */
	public $grid_line_id;

	/**
	 * Coordinates. X
	 *
	 * @var int
	 */
	public $x;

	/**
	 * Coordinates. Y
	 *
	 * @var int
	 */
	public $y;

	/**
	 * Width (1-12)
	 *
	 * @var int
	 */
	public $width;

	/**
	 * Content type
	 *
	 * @var int
	 */
	public $content_type;

	/**
	 * Content ID
	 *
	 * @var int
	 */
	public $content_id;

	/**
	 * Grid line's model
	 *
	 * @var GridLineModel
	 */
	public $gridLineModel;

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"gridLineModel" => ['models\GridLineModel', "grid_line_id"]
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "grids";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"grid_line_id" => [],
			"x"            => [],
			"y"            => [],
			"width"        => [],
			"content_type" => [],
			"content_id"   => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return GridModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Adds order by y & x to SQL request
	 *
	 * @return GridModel
	 */
	public function ordered()
	{
		$this->db->order = "t.y, t.x";
		return $this;
	}

	/**
	 * Adds order by line & y & x to SQL request
	 *
	 * @return GridModel
	 */
	public function orderedWithLines()
	{
		$this->db->order = "gridLineModel.sort, t.y, t.x";
		return $this;
	}

	/**
	 * Gets structure
	 *
	 * @param SectionModel $section Section model
	 *
	 * @return array
	 */
	public function getStructure(SectionModel $section)
	{
		$structure["width"] = $section->getWidth();

		$gridLineIds = [];
		$gridLineModels = GridLineModel::model()
			->with(["outsideDesignModel", "insideDesignModel"])
			->bySectionId($section->id)
			->ordered()
			->findAll();

		if (!$gridLineModels) {
			return [];
		}

		foreach ($gridLineModels as $gridLineModel) {
			$gridLineIds[] = $gridLineModel->id;
		}
		$gridModels = GridModel::model()->in("t.grid_line_id", $gridLineIds)->ordered()->findAll();
		$lines = [];

		foreach ($gridLineModels as $gridLineModel) {
			$grids = [];
			foreach ($gridModels as $gridModel) {
				if ($gridModel->grid_line_id == $gridLineModel->id) {
					$grids[] = $gridModel;
				}
			}
			$lines[$gridLineModel->sort] = [
				"line"  => $gridLineModel,
				"grids" => $grids
			];
		}

		foreach ($lines as $sort => $data) {
			$structure["lines"][$sort] = [
				"line"  => $data["line"],
				"grids" => $this->_getLineStructure($data["grids"])
			];
		}

		return $structure;
	}

	/**
	 * Gets line structure
	 *
	 * @param GridModel[] $grids Grid models
	 *
	 * @return array
	 */
	private function _getLineStructure($grids)
	{
		$structure = [];

		$doubleGrid = [];
		for ($i = 0; $i < self::GRID_SIZE * 2; $i++) {
			$doubleGrid[$i] = 0;
		}
		foreach ($grids as $grid) {
			for ($i = $grid->x * 2; $i < ($grid->x + $grid->width) * 2 - 1; $i++) {
				$doubleGrid[$i] = 1;
			}
		}

		$borders = [];
		$flag = 0;
		foreach ($doubleGrid as $x => $val) {
			if ($val != $flag) {
				$borders[] = $x;
				$flag = $val;
			}
		}

		if (!$borders) {
			return $structure;
		}

		for ($i = 0; $i < count($borders); $i = $i + 2) {
			if ($i) {
				$offset = ($borders[$i] - $borders[$i - 1] - 1) / 2;
			} else {
				$offset = $borders[$i] / 2;
			}

			$gridsList = [];
			$right = 0;
			$prevY = 0;
			foreach ($grids as $grid) {
				if (
					$grid->x >= $borders[$i] / 2
					&& $grid->x < $borders[$i + 1] / 2
					&& $grid->width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
				) {
					if ($grid->y > $prevY) {
						$right = 0;
					}
					$gridsList[] = [
						"model"  => $grid->getContentModel(),
						"view"   => $grid->getContentView(),
						"class"  => $grid->getBlockClass(),
						"col"    => $grid->width,
						"y"      => $grid->y,
						"offset" => $grid->x - $borders[$i] / 2 - $right,
					];
					$prevY = $grid->y;
					$right = $grid->x - $borders[$i] / 2 + $grid->width;
				}
			}

			$structure[] = [
				"col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
				"offset" => $offset,
				"grids"  => $gridsList,
			];
		}

		return $structure;
	}

	/**
	 * Adds section ID to SQL request
	 *
	 * @param int $sectionId Section ID
	 *
	 * @return GridModel
	 */
	public function bySectionId($sectionId)
	{
		$this->db->with[] = "gridLineModel";
		$this->db->addCondition("gridLineModel.section_id = :sectionId");
		$this->db->params["sectionId"] = $sectionId;

		return $this;
	}

	/**
	 * Adds line ID to SQL request
	 *
	 * @param int $lineId Line ID
	 *
	 * @return GridModel
	 */
	public function byLineId($lineId)
	{
		$this->db->addCondition("t.grid_line_id = :lineId");
		$this->db->params["lineId"] = $lineId;

		return $this;
	}

	/**
	 * Adds type to SQL request
	 *
	 * @param int $type Type
	 *
	 * @return GridModel
	 */
	public function byType($type)
	{
		$this->db->addCondition("t.content_type = :type");
		$this->db->params["type"] = $type;

		return $this;
	}

	/**
	 * Gets all grids for sections structure window
	 *
	 * @param int $sectionId Section ID
	 *
	 * @return array
	 */
	public function getAllGridsForGridWindow($sectionId)
	{
		$list = [];
		$typeList = self::getTypesList();

		$grids = $this->bySectionId($sectionId)->orderedWithLines()->findAll();
		foreach ($grids as $grid) {
			/**
			 * @var AbstractModel|TextModel $model
			 */
			$modelName = "\\models\\" . $typeList[$grid->content_type]["model"];
			$model = new $modelName;
			$model = $model->byId($grid->content_id)->find();
			$list[intval($grid->gridLineModel->sort)]["id"] = $grid->gridLineModel->id;
			$list[intval($grid->gridLineModel->sort)]["grids"][] = [
				"id"    => $grid->content_id,
				"x"     => $grid->x,
				"y"     => $grid->y,
				"width" => $grid->width,
				"type"  => $grid->content_type,
				"name"  => $model->name,
			];
		}

		return $list;
	}

	/**
	 * Updates grid'd structure for section
	 *
	 * @param int   $sectionId Section ID
	 * @param array $data      Structure data
	 *
	 * @throws ContentException
	 * @throws ModelException
	 */
	public function updateGridForSection($sectionId, $data)
	{
		$oldGrids = $this->bySectionId($sectionId)->findAll();
		$gridLines = GridLineModel::model()->bySectionId($sectionId)->findAll();
		$oldGridLines = [];
		foreach ($gridLines as $gridLine) {
			$oldGridLines[$gridLine->id] = $gridLine;
		}

		$lineNumber = 1;
		foreach ($data as $content) {
			if (!empty($content["id"])) {
				$gridLineModel = GridLineModel::model()->byId($content["id"])->find();
				if (!$gridLineModel) {
					throw new ContentException(
						"Unable to find GridLineModel with ID = {id}",
						[
							"id" => $content["id"]
						]
					);
				}

				$gridLineModel->sort = $lineNumber;
				if (!$gridLineModel->save()) {
					throw new ModelException("Unable to save GridLineModel");
				}

				if (array_key_exists($content["id"], $oldGridLines)) {
					unset($oldGridLines[$content["id"]]);
				}
			} else {
				$gridLineModel = new GridLineModel();
				$gridLineModel->section_id = $sectionId;
				$gridLineModel->sort = $lineNumber;
				if (!$gridLineModel->save()) {
					throw new ModelException("Unable to save GridLineModel");
				}
			}

			if (isset($content["items"]) && !is_array($content["items"])) {
				throw new ContentException("Unable to find items from content or items are not array");
			}

			foreach ($content["items"] as $item) {
				$model = new self;
				$model->grid_line_id = $gridLineModel->id;
				$model->x = $item["x"];
				$model->y = $item["y"];
				$model->width = $item["width"];
				$model->content_type = $item["type"];
				$model->content_id = $item["id"];
				if (!$model->save()) {
					throw new ModelException("Unable to save GridModel");
				}
			}

			$lineNumber++;
		}

		foreach ($oldGrids as $grid) {
			if (!$grid->delete()) {
				throw new ModelException(
					"Unable to delete GridModel with ID = {id}",
					[
						"id" => $grid->id
					]
				);
			}
		}

		/**
		 * @var \models\GridLineModel[] $oldGridLines
		 */
		foreach ($oldGridLines as $oldGridLine) {
			if (!$oldGridLine->delete()) {
				throw new ModelException(
					"Unable to delete old GridLineModel with ID = {id}",
					[
						"id" => $oldGridLine->id
					]
				);
			}
		}
	}

	/**
	 * Gets content types list
	 *
	 * @return array
	 */
	public static function getTypesList()
	{
		return [
			self::TYPE_TEXT => [
				"name"     => Language::t("text", "text"),
				"model"    => "TextModel",
				"view"     => "text",
				"selector" => "j-text-",
				"with"     => ["designTextModel"]
			]
		];
	}

	/**
	 * Gets content model
	 *
	 * @return AbstractModel
	 *
	 * @throws ModelException
	 */
	public function getContentModel()
	{
		$typeList = self::getTypesList();

		if (!array_key_exists($this->content_type, $typeList)) {
			throw new ModelException(
				"Unable to find content model. Type is undefined: {type}",
				[
					"type" => $this->content_type
				]
			);
		}

		/**
		 * @var AbstractModel $model
		 */
		$modelName = '\\models\\' . $typeList[$this->content_type]["model"];
		$model = new $modelName;
		$model = $model->byId($this->content_id)->withAll()->find();

		if (!$model) {
			throw new ModelException(
				"Unable to find content model {modelName} by ID {id}",
				[
					"modelName" => $modelName,
					"id"        => $this->content_id
				]
			);
		}

		return $model;
	}

	/**
	 * Gets content view
	 *
	 * @return string
	 *
	 * @throws ModelException
	 */
	public function getContentView()
	{
		$typeList = self::getTypesList();

		if (!array_key_exists($this->content_type, $typeList)) {
			throw new ModelException(
				"Unable to find content model. Type is undefined: {type}",
				[
					"type" => $this->content_type
				]
			);
		}

		return 'content.' . $typeList[$this->content_type]["view"];
	}

	/**
	 * Gets block class
	 *
	 * @return string
	 *
	 * @throws ModelException
	 */
	public function getBlockClass()
	{
		$typeList = self::getTypesList();

		if (!array_key_exists($this->content_type, $typeList)) {
			throw new ModelException(
				"Unable to find content model. Type is undefined: {type}",
				[
					"type" => $this->content_type
				]
			);
		}

		return $typeList[$this->content_type]["selector"] . $this->content_id;
	}

	/**
	 * Gets all blocks for sections window structure
	 *
	 * @return array
	 */
	public function getAllBlocksForGridWindow()
	{
		$list = [];
		$typeList = self::getTypesList();

		$models = TextModel::model()->ordered()->findAll();
		if ($models) {
			$list[] = [
				"name"       => $typeList[self::TYPE_TEXT]["name"],
				"isDisabled" => true,
				"type"       => 0,
				"id"         => 0,
			];
			foreach ($models as $model) {
				$list[] = [
					"name"       => $model->name,
					"isDisabled" => false,
					"type"       => self::TYPE_TEXT,
					"id"         => $model->id,
				];
			}
		}

		return $list;
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->grid_line_id = intval($this->grid_line_id);
		$this->content_type = intval($this->content_type);
		$this->content_id = intval($this->content_id);
		$this->x = intval($this->x);
		$this->y = intval($this->y);
		$this->width = intval($this->width);
	}

	/**
	 * Runs before save
	 *
	 * @throws ModelException
	 */
	protected function beforeSave()
	{
		if ($this->grid_line_id === 0 || GridLineModel::model()->byId($this->grid_line_id)->find() === null) {
			throw new ModelException(
				"Unable to find GridLineModel with ID = {id}", 
				[
					"id" => $this->grid_line_id
				]
			);
		}
		
		if ($this->content_type === 0 || $this->content_id === 0) {
			throw new ModelException("Unable to save GridModel because content_type or content_id is null");
		}
		
		$typeList = self::getTypesList();
		if (!array_key_exists($this->content_type, $typeList)) {
			throw new ModelException(
				"Unable to find content model. Type is undefined: {type}",
				[
					"type" => $this->content_type
				]
			);
		}
		
		$className = "\\models\\" . $typeList[$this->content_type]["model"];
		$model = new $className;
		if (
			!$model instanceof AbstractModel
			|| !$model->byId($this->content_id)->find()
		) {
			throw new ModelException(
				"Unable to find model: {className} with ID = {id}",
				[
					"className" => $className,
					"id"        => $this->content_id
				]
			);
		}
		
		if ($this->x < 0) {
			$this->x = 0;
		} else if ($this->x >= self::GRID_SIZE) {
			$this->x = self::GRID_SIZE - 1;
		}

		if ($this->y < 0) {
			$this->y = 0;
		}

		if ($this->width <= 0) {
			$this->width = self::DEFAULT_WIDTH;
		}
		if ($this->width >= self::GRID_SIZE) {
			$this->width = self::GRID_SIZE;
		}
		if ($this->width + $this->x > self::GRID_SIZE) {
			$this->width = self::GRID_SIZE - $this->x;
		}

		parent::beforeSave();
	}

	/**
	 * Duplicates model
	 *
	 * @param int  $gridLineId  Line's ID
	 *
	 * @return GridModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate($gridLineId)
	{
		$model = clone $this;
		$model->id = 0;
		$model->grid_line_id = $gridLineId;
		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate GridModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}
		
		return $model;
	}
}