<?php

namespace models;

/**
 * Model for working with table "image_albums"
 *
 * @package models
 *
 * @method ImageAlbumModel[] findAll
 * @method ImageAlbumModel   byId($id)
 * @method ImageAlbumModel   find
 * @method ImageAlbumModel   withAll
 */
class ImageAlbumModel extends AbstractModel
{

	/**
	 * Block's name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * ID of image collection
	 *
	 * @var integer
	 */
	public $image_id;

	/**
	 * Sort order
	 *
	 * @var boolean
	 */
	public $sort;

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [
		"name" => self::FORM_TYPE_FIELD,
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
			"name"     => ["required", "max" => 255],
			"image_id" => [],
			"sort"     => [],
		];
	}

	/**
	 * Gets model object
	 *
	 * @return ImageAlbumModel
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
		$this->image_id = intval($this->image_id);
		$this->sort = intval($this->sort);
	}

	/**
	 * Runs after finding model
	 *
	 * @return ImageAlbumModel
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

		if ($this->image_id === 0) {
			return false;
		}

		if (ImageModel::model()->byId($this->image_id)->find() === null) {
			return false;
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
	 * Add condition for select by image ID
	 *
	 * @param integer $imageId Image ID
	 *
	 * @return ImageAlbumModel
	 */
	public function byImageId($imageId)
	{
		$this->db->addCondition("t.image_id = :imageId");
		$this->db->params["imageId"] = $imageId;

		return $this;
	}

	/**
	 * Runs before delete
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		// @TODO delete instances

		return parent::beforeDelete();
	}
}