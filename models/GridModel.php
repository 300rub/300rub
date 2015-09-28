<?php

namespace models;

use system\base\Model;
use system\db\Db;

/**
 * Файл класса GridModel
 *
 * @package models
 *
 * @method GridModel[] findAll
 */
class GridModel extends Model
{

	const GRID_SIZE = 12;

	/**
	 * @var int
	 */
	public $section_id;

	/**
	 * @var int
	 */
	public $block_id;

	/**
	 * @var int
	 */
	public $line;

	/**
	 * @var int
	 */
	public $x;

	/**
	 * @var int
	 */
	public $y;

	/**
	 * @var int
	 */
	public $width;

	/**
	 * @var BlockModel
	 */
	public $blockModel = null;

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "grids";
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return [
			"blockModel" => ["models\\BlockModel", "block_id"]
		];
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"section_id" => ["required"],
			"block_id"   => ["required"],
			"line"       => ["required"],
			"x"          => [],
			"y"          => [],
			"width"      => ["required"],
		];
	}

	/**
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return [];
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return GridModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

	/**
	 * @param int $sectionId
	 *
	 * @return GridModel
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
	 * @return GridModel
	 */
	public function withBlocks()
	{
		$this->db->with[] = "blockModel";
		return $this;
	}

	/**
	 * @return GridModel
	 */
	public function ordered()
	{
		$this->db->order = "t.line, t.y, t.x";
		return $this;
	}

	/**
	 * @param SectionModel $section
	 *
	 * @return array
	 */
	public function getStructure(SectionModel $section)
	{
		$structure["width"] = $section->getWidth();
		$lines = [];

		$models = $this->bySectionId($section->id)->ordered()->withBlocks()->findAll();
		foreach ($models as $model) {
			$lines[$model->line][] = $model;
		}

		foreach ($lines as $number => $grids) {
			$structure["lines"][$number] = $this->_getLineStructure($grids);
		}

		return $structure;
	}

	/**
	 * @param GridModel[] $grids
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
			foreach ($grids as $grid) {
				if (
					$grid->x >= $borders[$i] / 2
					&& $grid->x < $borders[$i + 1] / 2
					&& $grid->width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
				) {
					$gridsList[] = [
						"model"  => $grid->blockModel->getContentModel(),
						"view"  => $grid->blockModel->getContentView(),
						"col"    => $grid->width,
						"y"      => $grid->y,
						"offset" => $grid->x - $borders[$i] / 2 - $right,
					];
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
	 * @param int $sectionId
	 *
	 * @return array
	 */
	public function getAllGridsForGridWindow($sectionId)
	{
		$list = [];
		$typesList = BlockModel::getTypesList();

		$grids = $this->bySectionId($sectionId)->withBlocks()->ordered()->findAll();
		foreach ($grids as $grid) {
			$list[intval($grid->line)][] = [
				"id"       => $grid->blockModel->id,
				"x"        => $grid->x,
				"y"        => $grid->y,
				"width"    => $grid->width,
				"cssClass" => $typesList[$grid->blockModel->type]["class"],
				"name"     => $grid->blockModel->name,
			];
		}

		//sort($list);

		return $list;
	}

	/**
	 * @param int $sectionId
	 * @param array $data
	 *
	 * @return bool
	 */
	public function updateGridForSection($sectionId, $data)
	{
		Db::startTransaction();
		$grids = $this->bySectionId($sectionId)->findAll();
		foreach ($grids as $grid) {
			if (!$grid->delete(false)) {
				Db::rollbackTransaction();
				return false;
			}
		}

		$lineNumber = 1;
		foreach ($data as $line) {
			foreach ($line as $item) {
				$model = new self;
				$model->section_id = $sectionId;
				$model->block_id = $item["id"];
				$model->line = $lineNumber;
				$model->x = $item["x"];
				$model->y = $item["y"];
				$model->width = $item["width"];
				if (!$model->save(false)) {
					Db::rollbackTransaction();
					return false;
				}
			}

			$lineNumber++;
		}

		Db::commitTransaction();
		return true;
	}
}