<?php

namespace models;

use components\exceptions\ModelException;

/**
 * Model for working with table "imageAlbums"
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
	public $imageId;

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
		return "imageAlbums";
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
			"imageId" => ["relation" => "\\models\\ImageModel"],
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
	protected function setValues()
	{
		$this->imageId = intval($this->imageId);
		$this->sort = intval($this->sort);
	}

	/**
	 * Runs before save
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if ($this->sort < 0) {
			$this->sort = 0;
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
	 * Add condition for select by image ID
	 *
	 * @param integer $imageId Image ID
	 *
	 * @return ImageAlbumModel
	 */
	public function byImageId($imageId)
	{
		$this->db->addCondition("t.imageId = :imageId");
		$this->db->params["imageId"] = $imageId;

		return $this;
	}

	/**
	 * Runs before delete
	 */
	protected function beforeDelete()
	{
		$imageInstances = ImageInstanceModel::model()->byAlbumId($this->id)->findAll();
		foreach ($imageInstances as $imageInstance) {
			if (!$imageInstance->delete()) {
				throw new ModelException(
					"Unable to delete ImageInstance with ID = {id}",
					[
						"id" => $imageInstance->id
					]
				);
			}
		}

		parent::beforeDelete();
	}
}