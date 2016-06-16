<?php

namespace models;

use components\Exception;
use components\Language;

/**
 * Model for working with table "images"
 *
 * @package models
 *
 * @method ImageModel[] findAll
 * @method ImageModel   byId($id)
 * @method ImageModel   find
 * @method ImageModel   withAll
 */
class ImageModel extends AbstractModel
{

	/**
	 * Block's name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Language ID
	 *
	 * @var integer
	 */
	public $language;

	/**
	 * ID of design block
	 *
	 * @var integer
	 */
	public $design_block_id;

	/**
	 * ID of design image block
	 *
	 * @var integer
	 */
	public $design_image_block_id;

	/**
	 * Design block model
	 *
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * Design image block model
	 *
	 * @var DesignBlockModel
	 */
	public $designImageBlockModel;

	/**
	 * Crop type
	 *
	 * @var integer
	 */
	public $crop_type;

	/**
	 * Crop width
	 *
	 * @var integer
	 */
	public $crop_width;

	/**
	 * Crop height
	 *
	 * @var integer
	 */
	public $crop_height;

	/**
	 * Crop crop x proportion
	 *
	 * @var integer
	 */
	public $crop_x;

	/**
	 * Crop crop y proportion
	 *
	 * @var integer
	 */
	public $crop_y;

	/**
	 * Is use albums
	 *
	 * @var boolean
	 */
	public $use_albums;

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"name" => self::FORM_TYPE_FIELD,
	];

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"designBlockModel"      => ['models\DesignBlockModel', "design_block_id"],
		"designImageBlockModel" => ['models\DesignBlockModel', "design_image_block_id"]
	];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "images";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"name"                  => ["required", "max" => 255],
			"language"              => [],
			"design_block_id"       => [],
			"design_image_block_id" => [],
			"crop_type"             => [],
			"crop_width"            => [],
			"crop_height"           => [],
			"crop_x"                => [],
			"crop_y"                => [],
			"use_albums"            => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return ImageModel
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
		$this->language = intval($this->language);
		if (
			$this->language === 0
			|| !array_key_exists($this->language, Language::$aliasList)
		) {
			$this->language = Language::$activeId;
		}

		$this->design_block_id = intval($this->design_block_id);
		$this->design_image_block_id = intval($this->design_image_block_id);

		$this->crop_type = intval($this->crop_type);
		$this->crop_width = intval($this->crop_width);
		$this->crop_height = intval($this->crop_height);
		$this->crop_x = intval($this->crop_x);
		$this->crop_y = intval($this->crop_y);

		$this->use_albums = boolval($this->use_albums);
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

		$this->use_albums = intval($this->use_albums);
		if ($this->use_albums >= 1) {
			$this->use_albums = 1;
		} else {
			$this->use_albums = 0;
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

		$imageInstances = ImageInstanceModel::model()->byAlbumId()->findAll();
		foreach ($imageInstances as $imageInstance) {
			if (!$imageInstance->delete()) {
				return false;
			}
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			if (!$designBlockModel->delete()) {
				return false;
			}
		}

		$designImageBlockModel = $this->designImageBlockModel;
		if ($designImageBlockModel === null) {
			$designImageBlockModel = DesignBlockModel::model()->byId($this->design_image_block_id)->find();
		}
		if ($designImageBlockModel instanceof DesignBlockModel) {
			if (!$designImageBlockModel->delete()) {
				return false;
			}
		}

		return parent::beforeDelete();
	}
}