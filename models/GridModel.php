<?php

namespace models;

use system\base\Model;

/**
 * Файл класса GridModel
 *
 * @package models
 */
class GridModel extends Model
{

	const GRID_SIZE = 12;

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

	public function relations()
	{
		return array(
			"blockModel" => array("models\\BlockModel", "block_id")
		);
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"section_id" => array(),
			"block_id"   => array(),
			"line"       => array(),
			"left"       => array(),
			"top"        => array(),
			"width"      => array(),
		);
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

	public function bySectionId($sectionId = null)
	{
		if ($sectionId) {
			$this->db->addCondition("t.section_id = :section_id");
			$this->db->params["section_id"] = $sectionId;
		}

		return $this;
	}

	public function withContent()
	{
		$this->db->with[] = "blockModel";
		return $this;
	}

	public static function getLines($grids)
	{
		$list = array();

		foreach ($grids as $grid) {
			$list[$grid->line][] = $grid;
		}

		return $list;
	}

	public static function getLineTree($grids)
	{
		$tree = array();

		$doubleGrid = array();
		for ($i = 0; $i < self::GRID_SIZE * 2; $i++) {
			$doubleGrid[$i] = 0;
		}
		foreach ($grids as $grid) {
			for ($i = $grid->left * 2; $i < ($grid->left + $grid->width) * 2 - 1; $i++) {
				$doubleGrid[$i] = 1;
			}
		}

		$borders = array();
		$flag = 0;
		foreach ($doubleGrid as $left => $val) {
			if ($val != $flag) {
				$borders[] = $left;
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

			$gridsList = array();
			$right = 0;
			foreach ($grids as $grid) {
				if (
					$grid->left >= $borders[$i] / 2
					&& $grid->left < $borders[$i + 1] / 2
					&& $grid->width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
				) {
					$gridsList[] = array(
						"block"  => $grid->blockModel,
						"col"    => $grid->width,
						"top"    => $grid->top,
						"offset" => $grid->left - $borders[$i] / 2 - $right,
					);
					$right = $grid->left - $borders[$i] / 2 + $grid->width;
				}
			}

			$tree[] = array(
				"col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
				"offset" => $offset,
				"grids"  => $gridsList,
			);
		}

		return $tree;
	}
}