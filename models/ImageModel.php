<?php

namespace models;

use components\exceptions\ModelException;
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
	 * Crop type. Top Left
	 */
	const CROP_TYPE_TOP_LEFT = 1;

	/**
	 * Crop type. Top Center
	 */
	const CROP_TYPE_TOP_CENTER = 2;

	/**
	 * Crop type. Top Right
	 */
	const CROP_TYPE_TOP_RIGHT = 3;

	/**
	 * Crop type. Middle Left
	 */
	const CROP_TYPE_MIDDLE_LEFT = 4;

	/**
	 * Crop type. Middle Center
	 */
	const CROP_TYPE_MIDDLE_CENTER = 5;

	/**
	 * Crop type. Middle Right
	 */
	const CROP_TYPE_MIDDLE_RIGHT = 6;

	/**
	 * Crop type. Bottom Left
	 */
	const CROP_TYPE_BOTTOM_LEFT = 7;

	/**
	 * Crop type. Bottom Center
	 */
	const CROP_TYPE_BOTTOM_CENTER = 8;

	/**
	 * Crop type. Bottom Right
	 */
	const CROP_TYPE_BOTTOM_RIGHT = 9;

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

		$cropTypeList = $this->getCropTypeList();
		if (!array_key_exists($this->crop_type, $cropTypeList)) {
			$this->crop_type = 0;
		}

		if ($this->crop_type !== 0) {
			if ($this->crop_width < 0) {
				$this->crop_width = 0;
			} elseif ($this->crop_width > ImageInstanceModel::MAX_SIZE) {
				$this->crop_width = ImageInstanceModel::MAX_SIZE;
			}

			if ($this->crop_height < 0) {
				$this->crop_height = 0;
			} elseif ($this->crop_height > ImageInstanceModel::MAX_SIZE) {
				$this->crop_height = ImageInstanceModel::MAX_SIZE;
			}

			if ($this->crop_width === 0 && $this->crop_height === 0) {
				if ($this->crop_x < 0) {
					$this->crop_x = 0;
				}
				if ($this->crop_y < 0) {
					$this->crop_y = 0;
				}
			} else {
				$this->crop_x = 0;
				$this->crop_y = 0;
			}
		} else {
			$this->crop_width = 0;
			$this->crop_height = 0;
			$this->crop_x = 0;
			$this->crop_y = 0;
		}

		parent::beforeSave();
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
	 * @return ImageModel
	 * 
	 * @throws ModelException
	 */
	public function duplicate()
	{
		$modelForCopy = $this->withAll()->byId($this->id)->find();

		$designBlockModel = $modelForCopy->designBlockModel->duplicate();
		$designImageBlockModel = $modelForCopy->designImageBlockModel->duplicate();

		$model = clone $this;
		$model->id = 0;
		$model->name = Language::t("common", "copy") . " {$this->name}";
		$model->designBlockModel = $designBlockModel;
		$model->design_block_id = $designBlockModel->id;
		$model->designImageBlockModel = $designImageBlockModel;
		$model->design_image_block_id = $designImageBlockModel->id;
		if (!$model->save()) {
			$fields = "";
			foreach ($model->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $model->$fieldName;
			}
			throw new ModelException(
				"Unable to duplicate ImageModel with fields: {fields}",
				[
					"fields" => $fields
				]
			);
		}
		
		return $model;
	}

	/**
	 * Runs before delete
	 * 
	 * @throws ModelException
	 */
	protected function beforeDelete()
	{
		$imageAlbums = ImageAlbumModel::model()->byImageId($this->id)->findAll();
		foreach ($imageAlbums as $imageAlbum) {
			if (!$imageAlbum->delete()) {
				throw new ModelException(
					"Unable to delete ImageAlbumModel model with ID = {id}",
					[
						"id" => $imageAlbum->id
					]
				);
			}
		}

		$imageInstances = ImageInstanceModel::model()->byAlbumId()->findAll();
		foreach ($imageInstances as $imageInstance) {
			if (!$imageInstance->delete()) {
				throw new ModelException(
					"Unable to delete ImageInstanceModel model with ID = {id}",
					[
						"id" => $imageInstance->id
					]
				);
			}
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->design_block_id)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			if (!$designBlockModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignBlockModel model with ID = {id}",
					[
						"id" => $designBlockModel->id
					]
				);
			}
		}

		$designImageBlockModel = $this->designImageBlockModel;
		if ($designImageBlockModel === null) {
			$designImageBlockModel = DesignBlockModel::model()->byId($this->design_image_block_id)->find();
		}
		if ($designImageBlockModel instanceof DesignBlockModel) {
			if (!$designImageBlockModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignBlockModel model with ID = {id}",
					[
						"id" => $designImageBlockModel->id
					]
				);
			}
		}

		parent::beforeDelete();
	}

	/**
	 * Gets crop type list
	 *
	 * @return array
	 */
	public function getCropTypeList()
	{
		return [
			self::CROP_TYPE_TOP_LEFT      => "",
			self::CROP_TYPE_TOP_CENTER    => "",
			self::CROP_TYPE_TOP_RIGHT     => "",
			self::CROP_TYPE_MIDDLE_LEFT   => "",
			self::CROP_TYPE_MIDDLE_CENTER => "",
			self::CROP_TYPE_MIDDLE_RIGHT  => "",
			self::CROP_TYPE_BOTTOM_LEFT   => "",
			self::CROP_TYPE_BOTTOM_CENTER => "",
			self::CROP_TYPE_BOTTOM_RIGHT  => ""
		];
	}
}