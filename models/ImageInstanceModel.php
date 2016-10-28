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
                self::FIELD_VALUE  => ["setFileName"],
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
                self::FIELD_VALUE  => [
                    "clearStripTags"
                ],
            ],
            "width"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => self::MIN_SIZE,
                    "setMax" => self::MAX_SIZE
                ],
            ],
            "height"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => self::MIN_SIZE,
                    "setMax" => self::MAX_SIZE
                ],
            ],
            "x1"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => 0,
                    "max" => ["{width}", self::MIN_SIZE, "-"]
                ],
            ],
            "y1"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => 0,
                    "max" => ["{height}", self::MIN_SIZE, "-"]
                ],
            ],
            "x2"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => ["{x1}", self::MIN_SIZE, "+"],
                    "max" => "{width}"
                ],
            ],
            "y2"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => ["{y1}", self::MIN_SIZE, "+"],
                    "max" => "{height}"
                ]
            ],
            "thumbX1"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => 0,
                    "max" => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbY1"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => 0,
                    "max" => self::MAX_THUMB_SIZE - self::MIN_SIZE
                ]
            ],
            "thumbX2"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => ["{thumbX1}", self::MIN_SIZE, "+"],
                    "max" => self::MAX_THUMB_SIZE
                ]
            ],
            "thumbY2"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE  => [
                    "min" => ["{thumbY1}", self::MIN_SIZE, "+"],
                    "max" => self::MAX_THUMB_SIZE
                ]
            ],
        ];
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