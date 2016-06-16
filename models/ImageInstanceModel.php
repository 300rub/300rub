<?php

namespace models;
use components\File;

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
	 * Min size in px
	 */
	const MIN_SIZE = 32;

	/**
	 * View prefix
	 */
	const VIEW_PREFIX = "view_";

	/**
	 * Thumb prefix
	 */
	const THUMB_PREFIX = "thumb_";

	/**
	 * File name length
	 */
	const FILE_NAME_LENGTH = 16;

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
	 * Thumb width of source image
	 *
	 * @var integer
	 */
	public $thumb_width;

	/**
	 * Thumb height of source image
	 *
	 * @var integer
	 */
	public $thumb_height;

	/**
	 * Thumb coordinates. x1
	 *
	 * @var integer
	 */
	public $thumb_x1;

	/**
	 * Thumb coordinates. y1
	 *
	 * @var integer
	 */
	public $thumb_y1;

	/**
	 * Thumb coordinates. x2
	 *
	 * @var integer
	 */
	public $thumb_x2;

	/**
	 * Thumb coordinates. y2
	 *
	 * @var integer
	 */
	public $thumb_y2;

	/**
	 * Format of file
	 *
	 * @var string
	 */
	private $_format;

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
			"thumb_width"    => [],
			"thumb_height"   => [],
			"thumb_x1"       => [],
			"thumb_y1"       => [],
			"thumb_x2"       => [],
			"thumb_y2"       => [],
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
		$this->thumb_width = intval($this->thumb_width);
		$this->thumb_height = intval($this->thumb_height);
		$this->thumb_x1 = intval($this->thumb_x1);
		$this->thumb_y1 = intval($this->thumb_y1);
		$this->thumb_x2 = intval($this->thumb_x2);
		$this->thumb_y2 = intval($this->thumb_y2);
	}

	/**
	 * Runs before save
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (
			$this->image_album_id <= 0
			|| ImageAlbumModel::model()->byId($this->image_album_id)->find() !== null
		) {
			$this->image_album_id = 0;
		}

		$this->is_cover = intval($this->is_cover);
		if ($this->is_cover >= 1) {
			$this->is_cover = 1;
		} else {
			$this->is_cover = 0;
		}

		if ($this->sort < 0) {
			$this->sort = 0;
		}

		if ($this->width < self::MIN_SIZE) {
			$this->width = self::MIN_SIZE;
		}
		if ($this->height < self::MIN_SIZE) {
			$this->height = self::MIN_SIZE;
		}

		if ($this->thumb_width < self::MIN_SIZE) {
			$this->thumb_width = self::MIN_SIZE;
		}
		if ($this->thumb_height < self::MIN_SIZE) {
			$this->thumb_height = self::MIN_SIZE;
		}

		if ($this->x1 < 0) {
			$this->x1 = 0;
		} elseif ($this->x1 > $this->width - self::MIN_SIZE) {
			$this->x1 = $this->width - self::MIN_SIZE;
		}
		if ($this->y1 < 0) {
			$this->y1 = 0;
		} elseif ($this->y1 > $this->height - self::MIN_SIZE) {
			$this->y1 = $this->height - self::MIN_SIZE;
		}
		if ($this->x2 < $this->x1 + self::MIN_SIZE) {
			$this->x2 = $this->x1 + self::MIN_SIZE;
		} elseif ($this->x2 > $this->width) {
			$this->x2 = $this->width;
		}
		if ($this->y2 < $this->y1 + self::MIN_SIZE) {
			$this->y2 = $this->y1 + self::MIN_SIZE;
		} elseif ($this->y2 > $this->height) {
			$this->y2 = $this->height;
		}

		if ($this->thumb_x1 < 0) {
			$this->thumb_x1 = 0;
		} elseif ($this->thumb_x1 > $this->thumb_width - self::MIN_SIZE) {
			$this->thumb_x1 = $this->thumb_width - self::MIN_SIZE;
		}
		if ($this->thumb_y1 < 0) {
			$this->thumb_y1 = 0;
		} elseif ($this->thumb_y1 > $this->thumb_height - self::MIN_SIZE) {
			$this->thumb_y1 = $this->thumb_height - self::MIN_SIZE;
		}
		if ($this->thumb_x2 < $this->thumb_x1 + self::MIN_SIZE) {
			$this->thumb_x2 = $this->thumb_x1 + self::MIN_SIZE;
		} elseif ($this->thumb_x2 > $this->thumb_width) {
			$this->thumb_x2 = $this->thumb_width;
		}
		if ($this->thumb_y2 < $this->thumb_y1 + self::MIN_SIZE) {
			$this->thumb_y2 = $this->thumb_y1 + self::MIN_SIZE;
		} elseif ($this->thumb_y2 > $this->thumb_height) {
			$this->thumb_y2 = $this->thumb_height;
		}

		if (!$this->id) {
			$this->file_name = $this->_generateFileName();
		}

		if (!$this->file_name) {
			return false;
		}

		return parent::beforeSave();
	}

	private function _generateFileName()
	{
		if (!$this->_format) {
			return null;
		}

		return substr(md5(time()), 0, self::FILE_NAME_LENGTH) . "." . $this->_format;
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->alt = trim(strip_tags($this->alt));
	}

	/**
	 * Runs before deleting
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		$file = new File($this->file_name);
		$fileView = new File(self::VIEW_PREFIX . $this->file_name);
		$fileThumb = new File(self::THUMB_PREFIX . $this->file_name);

		$file->delete();
		$fileView->delete();
		$fileThumb->delete();

		return parent::beforeDelete();
	}

	/**
	 * Add condition for select by image ID
	 *
	 * @param integer $imageAlbumId ImageAlbum ID
	 *
	 * @return ImageInstanceModel
	 */
	public function byAlbumId($imageAlbumId = 0)
	{
		$this->db->addCondition("t.image_album_id = :imageAlbumId");
		$this->db->params["imageAlbumId"] = $imageAlbumId;

		return $this;
	}
}