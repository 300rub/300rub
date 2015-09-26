<?php

namespace models;

use system\base\Model;

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

	public static function getLines($grids)
	{
		$list = [];

		foreach ($grids as $grid) {
			$list[$grid->line][] = $grid;
		}

		return $list;
	}

	public static function getLineTree($grids)
	{
		$tree = [];

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
			return $tree;
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
						"block"  => $grid->blockModel,
						"col"    => $grid->width,
						"y"      => $grid->y,
						"offset" => $grid->x - $borders[$i] / 2 - $right,
					];
					$right = $grid->x - $borders[$i] / 2 + $grid->width;
				}
			}

			$tree[] = [
				"col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
				"offset" => $offset,
				"grids"  => $gridsList,
			];
		}

		return $tree;
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
			$list[$grid->line][] = [
				"id"       => $grid->blockModel->id,
				"x"        => $grid->x,
				"y"        => $grid->y,
				"width"    => $grid->width,
				"cssClass" => $typesList[$grid->blockModel->type]["class"],
				"name"     => $grid->blockModel->name,
			];
		}

		sort($list);

		return $list;
	}
}