<?php

namespace models;

use components\Exception;
use components\Language;

/**
 * Model for working with table "image_instances"
 *
 * @package models
 *
 * @method ImageModel[] findAll
 * @method ImageModel   byId($id)
 * @method ImageModel   find
 * @method ImageModel   withAll
 */
class ImageInstanceModel extends AbstractModel
{

	/**
	 * Min image size in pixels
	 */
	const MIN_SIZE = 32;

	/**
	 * The name of file
	 *
	 * @var string
	 */
	public $file_name;

	/**
	 * ID of image album
	 *
	 * @var integer
	 */
	public $image_album_id;

	/**
	 * Flag. Is albums cover
	 *
	 * @var boolean
	 */
	public $is_cover;

	/**
	 * Sort order
	 *
	 * @var integer
	 */
	public $sort;

	/**
	 * Image alt / description
	 *
	 * @var string
	 */
	public $alt;

	/**
	 * Width of source image
	 *
	 * @var integer
	 */
	public $width;

	/**
	 * Height of source image
	 *
	 * @var integer
	 */
	public $height;

	/**
	 * Coordinates. x1
	 *
	 * @var integer
	 */
	public $x1;

	/**
	 * Coordinates. y1
	 *
	 * @var integer
	 */
	public $y1;

	/**
	 * Coordinates. x2
	 *
	 * @var integer
	 */
	public $x2;

	/**
	 * Coordinates. y2
	 *
	 * @var integer
	 */
	public $y2;

	/**
	 * Thumb coordinates. x1
	 *
	 * @var integer
	 */
	public $x1_thumb;

	/**
	 * Thumb coordinates. y1
	 *
	 * @var integer
	 */
	public $y1_thumb;

	/**
	 * Thumb coordinates. x2
	 *
	 * @var integer
	 */
	public $x2_thumb;

	/**
	 * Thumb coordinates. y2
	 *
	 * @var integer
	 */
	public $y2_thumb;

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"alt" => self::FORM_TYPE_FIELD,
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "image_instances";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"file_name"      => [],
			"image_album_id" => [],
			"is_cover"       => [],
			"sort"           => [],
			"alt"            => [],
			"width"          => [],
			"height"         => [],
			"x1"             => [],
			"y1"             => [],
			"x2"             => [],
			"y2"             => [],
			"x1_thumb"       => [],
			"y1_thumb"       => [],
			"x2_thumb"       => [],
			"y2_thumb"       => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return ImageInstanceModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->image_album_id = intval($this->image_album_id);
		$this->is_cover = boolval($this->is_cover);
		$this->sort = intval($this->sort);
		$this->width = intval($this->width);
		$this->height = intval($this->height);
		$this->x1 = intval($this->x1);
		$this->y1 = intval($this->y1);
		$this->x2 = intval($this->x2);
		$this->y2 = intval($this->y2);
		$this->x1_thumb = intval($this->x1_thumb);
		$this->y1_thumb = intval($this->y1_thumb);
		$this->x2_thumb = intval($this->x2_thumb);
		$this->y2_thumb = intval($this->y2_thumb);
	}

	/**
	 * Runs before save
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
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

		if (!$this->designImageBlockModel instanceof DesignBlockModel) {
			if ($this->design_image_block_id === 0) {
				$this->designImageBlockModel = new DesignBlockModel();
			} else {
				$this->designImageBlockModel = DesignBlockModel::model()->byId($this->design_image_block_id)->find();
				if ($this->designImageBlockModel === null) {
					$this->designImageBlockModel = new DesignBlockModel();
				}
			}
		}

		return parent::beforeSave();
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->name = trim(strip_tags($this->name));
	}

	/**
	 * Duplicates image
	 * If success returns ID of new image
	 *
	 * @return ImageModel|null
	 */
	public function duplicate()
	{
		try {
			$modelForCopy = $this->withAll()->byId($this->id)->find();

			$designBlockModel = $modelForCopy->designBlockModel->duplicate();
			if ($designBlockModel === null) {
				return null;
			}

			$designImageBlockModel = $modelForCopy->designImageBlockModel->duplicate();
			if ($designImageBlockModel === null) {
				return null;
			}

			$model = clone $this;
			$model->id = 0;
			$model->name = Language::t("common", "copy") . " {$this->name}";
			$model->designBlockModel = $designBlockModel;
			$model->design_block_id = $designBlockModel->id;
			$model->designImageBlockModel = $designImageBlockModel;
			$model->design_image_block_id = $designImageBlockModel->id;
			if (!$model->save()) {
				return null;
			}
			
			return $model;
		} catch (Exception $e) {
			return null;
		}
	}

	/**
	 * Runs before delete
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		$imageAlbums = ImageAlbumModel::model()->byImageId($this->id)->findAll();
		foreach ($imageAlbums as $imageAlbum) {
			if (!$imageAlbum->delete()) {
				return false;
			}
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			$designBlockModel->delete();
		}

		$designImageBlockModel = $this->designImageBlockModel;
		if ($designImageBlockModel === null) {
			$designImageBlockModel = DesignBlockModel::model()->byId($this->design_image_block_id)->find();
		}
		if ($designImageBlockModel instanceof DesignBlockModel) {
			$designImageBlockModel->delete();
		}

		return parent::beforeDelete();
	}
}