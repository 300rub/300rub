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
	 * Default crop type
	 */
	const DEFAULT_CROP_TYPE = self::CROP_TYPE_MIDDLE_CENTER;

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
	 * Design block model
	 *
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * ID of design image slider
	 *
	 * @var integer
	 */
	public $design_image_slider_id;

	/**
	 * Design image slider model
	 *
	 * @var DesignImageSliderModel
	 */
	public $designImageSliderModel;

	/**
	 * ID of design image slider
	 *
	 * @var integer
	 */
	public $design_image_zoom_id;

	/**
	 * Design image zoom model
	 *
	 * @var DesignImageZoomModel
	 */
	public $designImageZoomModel;

	/**
	 * ID of design image simple
	 *
	 * @var integer
	 */
	public $design_image_simple_id;

	/**
	 * Design image simple model
	 *
	 * @var DesignBlockModel
	 */
	public $designImageSimpleModel;

	/**
	 * Flag of using cropping
	 *
	 * @var bool
	 */
	public $use_crop;

	/**
	 * Flag of auto cropping
	 *
	 * @var bool
	 */
	public $is_auto_crop;

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
		"designBlockModel"       => ['models\DesignBlockModel', "design_block_id"],
		"designImageSliderModel" => ['models\DesignImageSliderModel', "design_image_slider_id"],
		"designImageZoomModel"   => ['models\DesignImageZoomModel', "design_image_zoom_id"],
		"designImageSimpleModel" => ['models\DesignBlockModel', "design_image_slider_id"]
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
			"name"                   => ["required", "max" => 255],
			"language"               => [],
			"design_block_id"        => [],
			"design_image_slider_id" => [],
			"design_image_zoom_id"   => [],
			"design_image_simple_id" => [],
			"use_crop"               => [],
			"is_auto_crop"           => [],
			"crop_type"              => [],
			"crop_width"             => [],
			"crop_height"            => [],
			"crop_x"                 => [],
			"crop_y"                 => [],
			"use_albums"             => [],
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
		if ($this->language === 0
			|| !array_key_exists($this->language, Language::$aliasList)
		) {
			$this->language = Language::$activeId;
		}

		$this->design_block_id = intval($this->design_block_id);
		$this->design_image_slider_id = intval($this->design_image_slider_id);
		$this->design_image_zoom_id = intval($this->design_image_zoom_id);
		$this->design_image_simple_id = intval($this->design_image_simple_id);

		$this->use_crop = boolval($this->use_crop);
		$this->is_auto_crop = boolval($this->is_auto_crop);
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
		$this->designBlockModel = $this->getRelationModel(
			$this->designBlockModel,
			$this->design_block_id,
			"DesignBlockModel"
		);

		$this->designImageSliderModel = $this->getRelationModel(
			$this->designImageSliderModel,
			$this->design_image_slider_id,
			"DesignImageSliderModel"
		);

		$this->designImageZoomModel = $this->getRelationModel(
			$this->designImageZoomModel,
			$this->design_image_zoom_id,
			"DesignImageZoomModel"
		);

		$this->designImageSimpleModel = $this->getRelationModel(
			$this->designImageSimpleModel,
			$this->design_image_simple_id,
			"DesignBlockModel"
		);

		$this->use_crop = $this->getTinyIntVal($this->use_crop);
		$this->is_auto_crop = $this->getTinyIntVal($this->is_auto_crop);

		if ($this->use_crop === 1) {
			$cropTypeList = $this->getCropTypeList();
			if (!array_key_exists($this->crop_type, $cropTypeList)) {
				$this->crop_type = self::DEFAULT_CROP_TYPE;
			}

			$this->crop_width = $this->getIntVal($this->crop_width, ImageInstanceModel::MAX_SIZE);
			$this->crop_height = $this->getIntVal($this->crop_height, ImageInstanceModel::MAX_SIZE);
			$this->crop_x = $this->getIntVal($this->crop_x);
			$this->crop_y = $this->getIntVal($this->crop_y);
		}

		$this->use_albums = $this->getTinyIntVal($this->use_albums);

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

		$model = clone $this;
		$model->id = 0;
		$model->name = Language::t("common", "copy") . " {$this->name}";
		$model->designBlockModel = $modelForCopy->designBlockModel->duplicate();
		$model->designImageSimpleModel = $modelForCopy->designImageSimpleModel->duplicate();
		$model->designImageSliderModel = $modelForCopy->designImageSliderModel->duplicate();
		$model->designImageZoomModel = $modelForCopy->designImageZoomModel->duplicate();
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

		$this
			->deleteRelation($this->designBlockModel, $this->design_block_id, "DesignBlockModel")
			->deleteRelation($this->designImageZoomModel, $this->design_image_zoom_id, "DesignImageZoomModel")
			->deleteRelation($this->designImageSliderModel, $this->design_image_slider_id, "DesignImageSliderModel")
			->deleteRelation($this->designImageSimpleModel, $this->design_image_simple_id, "DesignBlockModel");

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