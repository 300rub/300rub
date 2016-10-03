<?php

namespace models;

use components\exceptions\ModelException;
use components\File;

/**
 * Model for working with table "imageInstances"
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
	 * Max size in px
	 */
	const MAX_SIZE = 2000;

	/**
	 * Max thumb size in px
	 */
	const MAX_THUMB_SIZE = 300;

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
	public $fileName;

	/**
	 * ID of image album
	 *
	 * @var integer
	 */
	public $imageAlbumId;

	/**
	 * Flag. Is albums cover
	 *
	 * @var boolean
	 */
	public $isCover;

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
	public $thumbX1;

	/**
	 * Thumb coordinates. y1
	 *
	 * @var integer
	 */
	public $thumbY1;

	/**
	 * Thumb coordinates. x2
	 *
	 * @var integer
	 */
	public $thumbX2;

	/**
	 * Thumb coordinates. y2
	 *
	 * @var integer
	 */
	public $thumbY2;

	/**
	 * Format of file
	 *
	 * @var string
	 */
	private $_format = "jpg";

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
		return "imageInstances";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"fileName"      => [],
			"imageAlbumId" => ["relation" => "\\models\\ImageAlbumModel"],
			"isCover"       => [],
			"sort"           => [],
			"alt"            => [],
			"width"          => [],
			"height"         => [],
			"x1"             => [],
			"y1"             => [],
			"x2"             => [],
			"y2"             => [],
			"thumbX1"       => [],
			"thumbY1"       => [],
			"thumbX2"       => [],
			"thumbY2"       => [],
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
		$this->imageAlbumId = (int) $this->imageAlbumId;
		$this->isCover = boolval($this->isCover);
		$this->sort = intval($this->sort);
		$this->width = intval($this->width);
		$this->height = intval($this->height);
		$this->x1 = intval($this->x1);
		$this->y1 = intval($this->y1);
		$this->x2 = intval($this->x2);
		$this->y2 = intval($this->y2);
		$this->thumbX1 = intval($this->thumbX1);
		$this->thumbY1 = intval($this->thumbY1);
		$this->thumbX2 = intval($this->thumbX2);
		$this->thumbY2 = intval($this->thumbY2);
	}

	/**
	 * Runs before save
	 */
	protected function beforeSave()
	{
		$this->isCover = $this->getTinyIntVal($this->isCover);

		if ($this->sort < 0) {
			$this->sort = 0;
		}

		if ($this->width < self::MIN_SIZE) {
			$this->width = self::MIN_SIZE;
		} elseif ($this->width > self::MAX_SIZE) {
			$this->width = self::MAX_SIZE;
		}
		if ($this->height < self::MIN_SIZE) {
			$this->height = self::MIN_SIZE;
		} elseif ($this->height > self::MAX_SIZE) {
			$this->height = self::MAX_SIZE;
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

		$maxThumbWidth = self::MAX_THUMB_SIZE;
		if ($maxThumbWidth > $this->width) {
			$maxThumbWidth = $this->width;
		}
		$maxThumbHeight = self::MAX_THUMB_SIZE;
		if ($maxThumbHeight > $this->height) {
			$maxThumbHeight = $this->height;
		}
		if ($this->thumbX1 < 0) {
			$this->thumbX1 = 0;
		} elseif ($this->thumbX1 > $maxThumbWidth - self::MIN_SIZE) {
			$this->thumbX1 = $maxThumbWidth - self::MIN_SIZE;
		}
		if ($this->thumbY1 < 0) {
			$this->thumbY1 = 0;
		} elseif ($this->thumbY1 > $maxThumbHeight - self::MIN_SIZE) {
			$this->thumbY1 = $maxThumbHeight - self::MIN_SIZE;
		}
		if ($this->thumbX2 < $this->thumbX1 + self::MIN_SIZE) {
			$this->thumbX2 = $this->thumbX1 + self::MIN_SIZE;
		} elseif ($this->thumbX2 > $maxThumbWidth) {
			$this->thumbX2 = $maxThumbWidth;
		}
		if ($this->thumbY2 < $this->thumbY1 + self::MIN_SIZE) {
			$this->thumbY2 = $this->thumbY1 + self::MIN_SIZE;
		} elseif ($this->thumbY2 > $maxThumbHeight) {
			$this->thumbY2 = $maxThumbHeight;
		}

		if (!$this->id) {
			$this->fileName = $this->_generateFileName();
		}

		if (!$this->fileName) {
			throw new ModelException("Unable to save ImageInstanceModel because fileName is null");
		}

		parent::beforeSave();
	}

	/**
	 * Generates File name
	 *
	 * @return null|string
	 */
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
	 */
	protected function beforeDelete()
	{
		$file = new File($this->fileName);
		$fileView = new File(self::VIEW_PREFIX . $this->fileName);
		$fileThumb = new File(self::THUMB_PREFIX . $this->fileName);

		$file->delete();
		$fileView->delete();
		$fileThumb->delete();

		parent::beforeDelete();
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
		$this->db->addCondition("t.imageAlbumId = :imageAlbumId");
		$this->db->params["imageAlbumId"] = $imageAlbumId;

		return $this;
	}
}