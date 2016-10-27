<?php

namespace testS\models;

/**
 * Model for working with table "imageInstances"
 *
 * @property int $width
 * @property int $height
 * @property int $x1
 * @property int $y1
 * @property int $thumbX1
 * @property int $thumbY1
 *
 * @method ImageModel[] findAll
 * @method ImageModel   byId($id)
 * @method ImageModel   find
 * @method ImageModel   withAll
 *
 * @package testS\models
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
     * Format of file
     *
     * @var string
     */
    private $_format = "jpg";

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
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "imageInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "fileName"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SET  => ["setFileName"],
            ],
            "imageAlbumId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "ImageAlbumModel",
                    self::FIELD_RELATION_NAME  => "imageAlbumModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_HAS_ONE
                ]
            ],
            "isCover"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "sort"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "alt"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SET  => ["clearStripTags"],
            ],
            "width"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_SIZE, "setMax" => self::MAX_SIZE],
            ],
            "height"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_SIZE, "setMax" => self::MAX_SIZE],
            ],
            "x1"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0, "setX1"],
            ],
            "y1"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0, "setY1"],
            ],
            "x2"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0, "setX2"],
            ],
            "y2"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0, "setY2"],
            ],
            "thumbX1"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbY1"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbX2"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbY2"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }

    /**
     * Sets x1
     *
     * @param int $value
     *
     * @return int
     */
    protected function setX1($value)
    {
        if ($value > $this->width - self::MIN_SIZE) {
            $value = $this->width - self::MIN_SIZE;
        }

        return $value;
    }

    /**
     * Sets y1
     *
     * @param int $value
     *
     * @return int
     */
    protected function setY1($value)
    {
        if ($value > $this->height - self::MIN_SIZE) {
            $value = $this->height - self::MIN_SIZE;
        }

        return $value;
    }

    /**
     * Sets x2
     *
     * @param int $value
     *
     * @return int
     */
    protected function setX2($value)
    {
        if ($value < $this->x1 + self::MIN_SIZE) {
            $value = $this->x1 + self::MIN_SIZE;
        } elseif ($value > $this->width) {
            $value = $this->width;
        }

        return $value;
    }

    /**
     * Sets y2
     *
     * @param int $value
     *
     * @return int
     */
    protected function setY2($value)
    {
        if ($value < $this->y1 + self::MIN_SIZE) {
            $value = $this->y1 + self::MIN_SIZE;
        } elseif ($value > $this->height) {
            $value = $this->height;
        }

        return $value;
    }

    /**
     * Sets thumbX1
     *
     * @param int $value
     *
     * @return int
     */
    protected function setThumbX1($value)
    {
        $maxThumbWidth = self::MAX_THUMB_SIZE;
        if ($maxThumbWidth > $this->width) {
            $maxThumbWidth = $this->width;
        }

        if ($value > $maxThumbWidth - self::MIN_SIZE) {
            $value = $maxThumbWidth - self::MIN_SIZE;
        }

        return $value;
    }

    /**
     * Sets thumbY1
     *
     * @param int $value
     *
     * @return int
     */
    protected function setThumbY1($value)
    {
        $maxThumbHeight = self::MAX_THUMB_SIZE;
        if ($maxThumbHeight > $this->height) {
            $maxThumbHeight = $this->height;
        }

        if ($value < 0) {
            $value = 0;
        } elseif ($value > $maxThumbHeight - self::MIN_SIZE) {
            $value = $maxThumbHeight - self::MIN_SIZE;
        }

        return $value;
    }

    /**
     * Sets thumbX2
     *
     * @param int $value
     *
     * @return int
     */
    protected function setThumbX2($value)
    {
        $maxThumbWidth = self::MAX_THUMB_SIZE;
        if ($maxThumbWidth > $this->width) {
            $maxThumbWidth = $this->width;
        }

        if ($value < $this->thumbX1 + self::MIN_SIZE) {
            $value = $this->thumbX1 + self::MIN_SIZE;
        } elseif ($value > $maxThumbWidth) {
            $value = $maxThumbWidth;
        }

        return $value;
    }

    /**
     * Sets thumbY2
     *
     * @param int $value
     *
     * @return int
     */
    protected function setThumbY2($value)
    {
        $maxThumbHeight = self::MAX_THUMB_SIZE;
        if ($maxThumbHeight > $this->height) {
            $maxThumbHeight = $this->height;
        }

        if ($value < $this->thumbY1 + self::MIN_SIZE) {
            $value = $this->thumbY1 + self::MIN_SIZE;
        } elseif ($value > $maxThumbHeight) {
            $value = $maxThumbHeight;
        }

        return $value;
    }

    /**
     * Sets file name
     *
     * @param string $value
     *
     * @return string
     */
    protected function setFileName($value)
    {
        if (!$this->id && $this->_format) {
            return substr(md5(time()), 0, self::FILE_NAME_LENGTH) . "." . $this->_format;
        }

        return $value;
    }

    /**
     * Runs before deleting
     */
    protected function beforeDelete()
    {
        //		$file = new File($this->fileName);
        //		$fileView = new File(self::VIEW_PREFIX . $this->fileName);
        //		$fileThumb = new File(self::THUMB_PREFIX . $this->fileName);
        //
        //		$file->delete();
        //		$fileView->delete();
        //		$fileThumb->delete();

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
        $this->getDb()
            ->addWhere("imageAlbumId = :imageAlbumId")
            ->addParameter("imageAlbumId", $imageAlbumId);

        return $this;
    }
}