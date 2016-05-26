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
	 * Sort order
	 *
	 * @var integer
	 */
	public $x1;

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
	private function _setValues()
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
	}

	/**
	 * Runs after finding model
	 *
	 * @return ImageModel
	 */
	protected function afterFind()
	{
		parent::afterFind();

		$this->_setValues();
	}

	/**
	 * Runs before save
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		$this->_setValues();

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