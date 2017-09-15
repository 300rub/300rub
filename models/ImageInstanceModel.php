<?php

namespace testS\models;

use testS\components\exceptions\FileException;
use testS\components\ValueGenerator;

/**
 * Model for working with table "imageInstances"
 *
 * @package testS\models
 */
class ImageInstanceModel extends AbstractModel
{

    /**
     * Max size in px
     */
    const VIEW_MAX_SIZE = 2000;

    /**
     * Max thumb size in px
     */
    const THUMB_MAX_SIZE = 300;

    /**
     * View prefix
     */
    const VIEW_PREFIX = "view_";

    /**
     * Thumb prefix
     */
    const THUMB_PREFIX = "thumb_";

    // Extensions
    const EXT_JPG = "jpg";
    const EXT_PNG = "png";

    /**
     * Image info
     *
     * @var array|bool
     */
    private $_info = false;

    /**
     * Extension
     *
     * @var string
     */
    private $_extension = "";

    /**
     * View width
     *
     * @var int
     */
    private $_viewWidth = 0;

    /**
     * View height
     *
     * @var int
     */
    private $_viewHeight = 0;

    /**
     * Thumb width
     *
     * @var int
     */
    private $_thumbWidth = 0;

    /**
     * Thumb height
     *
     * @var int
     */
    private $_thumbHeight = 0;

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
    public function getFieldsInfo()
    {
        return [
            "originalFileId"       => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "viewFileId"       => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbFileId"       => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "imageAlbumId" => [
                self::FIELD_RELATION_TO_PARENT => "ImageGroupModel",
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            "isCover"      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "sort"         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "alt"          => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "width"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "height"       => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x1"           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y1"           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x2"           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y2"           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX1"      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY1"      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX2"      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY2"      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Uploads the file
     *
     * @return array
     */
    public function upload()
    {
        $this
            ->_checkImageAlbumId()
            ->_setOriginalFileModel()
            ->_setInfo()
            ->_setExtension()
            ->_setSizes()
            ->_uploadOriginalFile()
            ->_setViewFileModel()
            ->_setThumbFileModel()
            ->_uploadImage()
            ->save();

        return [
            "originalUrl"  => $this->get("originalFileModel")->getUrl(),
            "viewUrl"      => $this->get("viewFileModel")->getUrl(),
            "thumbUrl"     => $this->get("thumbFileModel")->getUrl(),
            "name"         => str_replace(
                sprintf(".%s", $this->_extension),
                "",
                $this->get("originalFileModel")->get("originalName")
            ),
            "id"           => $this->getId()
        ];
    }

    /**
     * Checks image album ID
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _checkImageAlbumId()
    {
        if ($this->get("imageAlbumId") === 0) {
            throw new FileException("Unable to upload image because imageAlbumId is 0");
        }

        return $this;
    }

    /**
     * Uploads view and thumb images
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _uploadImage()
    {
        switch ($this->_extension) {
            case self::EXT_JPG:
                $this->_saveJpg();
                break;
            case self::EXT_PNG:
                $this->_savePng();
                break;
            default:
                throw new FileException(
                    "Unable to upload image with extension: {extension}",
                    [
                        "extension" => $this->_extension
                    ]
                );
        }

        $this->get("viewFileModel")->setSizeFromTmpFile()->upload();
        $this->get("thumbFileModel")->setSizeFromTmpFile()->upload();

        return $this;
    }

    /**
     * Sets original file model
     *
     * @return ImageInstanceModel
     */
    private function _setOriginalFileModel()
    {
        $this->set(
            [
                "originalFileModel" => (new FileModel())->parsePostRequest()
            ]
        );

        return $this;
    }

    /**
     * Uploads original file
     *
     * @return ImageInstanceModel
     */
    private function _uploadOriginalFile()
    {
        $this->get("originalFileModel")
            ->setUniqueName($this->_extension)
            ->upload();

        return $this;
    }

    /**
     * Sets view file model
     *
     * @return ImageInstanceModel
     */
    private function _setViewFileModel()
    {
        $this->set(
            [
                "viewFileModel" => (new FileModel())
                    ->generateTmpName()
                    ->set(
                        [
                            "uniqueName" => self::VIEW_PREFIX . $this->get("originalFileModel")->get("uniqueName"),
                            "type"       => $this->get("originalFileModel")->get("type")
                        ]
                    )
            ]
        );

        return $this;
    }

    /**
     * Sets thumb file model
     *
     * @return ImageInstanceModel
     */
    private function _setThumbFileModel()
    {
        $this->set(
            [
                "thumbFileModel" => (new FileModel())
                    ->generateTmpName()
                    ->set(
                        [
                            "uniqueName" => self::THUMB_PREFIX . $this->get("originalFileModel")->get("uniqueName"),
                            "type"       => $this->get("originalFileModel")->get("type")
                        ]
                    )
            ]
        );

        return $this;
    }

    /**
     * Sets info
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _setInfo()
    {
        $this->_info = getimagesize($this->get("originalFileModel")->getTmpName());
        if (!is_array($this->_info)) {
            throw new FileException(
                "Uploaded file: {file} is not an image",
                [
                    "file" => $this->get("originalFileModel")->get("originalName")
                ]
            );
        }

        if (!array_key_exists("mime", $this->_info)) {
            throw new FileException(
                "Unable to get image mime. Info: {info}",
                [
                    "info" => json_encode($this->_info)
                ]
            );
        }

        return $this;
    }

    /**
     * Sets extension
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _setExtension()
    {
        $mime = $this->_info["mime"];

        if (stripos($mime, "image") === false) {
            throw new FileException(
                "File with mime: {mime} is not an image",
                [
                    "mime" => $mime
                ]
            );
        }

        if (stripos($mime, "jpg") !== false || stripos($mime, "jpeg") !== false) {
            $this->_extension = self::EXT_JPG;
        } elseif (stripos($mime, "png") !== false) {
            $this->_extension = self::EXT_PNG;
        } else {
            throw new FileException(
                "Unable to upload image with mime: {mime}",
                [
                    "mime" => $mime
                ]
            );
        }

        return $this;
    }

    /**
     * Sets sizes
     *
     * @return ImageInstanceModel
     */
    private function _setSizes()
    {
        list($originalWidth, $originalHeight) = $this->_info;

        $viewWidth = $originalWidth;
        $viewHeight = $originalHeight;
        $thumbWidth = $originalWidth;
        $thumbHeight = $originalHeight;

        if ($originalWidth > $originalHeight) {
            if ($viewWidth > self::VIEW_MAX_SIZE) {
                $k = $viewWidth / self::VIEW_MAX_SIZE;
                $viewWidth = self::VIEW_MAX_SIZE;
                $viewHeight = $viewHeight / $k;
            }

            if ($thumbWidth > self::VIEW_MAX_SIZE) {
                $k = $thumbWidth / self::THUMB_MAX_SIZE;
                $thumbWidth = self::THUMB_MAX_SIZE;
                $thumbHeight = $thumbHeight / $k;
            }
        } else {
            if ($viewHeight > self::VIEW_MAX_SIZE) {
                $k = $viewHeight / self::VIEW_MAX_SIZE;
                $viewHeight = self::VIEW_MAX_SIZE;
                $viewWidth = $viewWidth / $k;
            }

            if ($thumbHeight > self::VIEW_MAX_SIZE) {
                $k = $thumbHeight / self::THUMB_MAX_SIZE;
                $thumbHeight = self::THUMB_MAX_SIZE;
                $thumbWidth = $thumbWidth / $k;
            }
        }

        $this->set(
            [
                "width"  => $originalWidth,
                "height" => $originalHeight,
            ]
        );

        $this->_viewWidth = $viewWidth;
        $this->_viewHeight = $viewHeight;
        $this->_thumbWidth = $thumbWidth;
        $this->_thumbHeight = $thumbHeight;

        return $this;
    }

    /**
     * Saves JPG
     *
     * @return ImageInstanceModel
     */
    private function _saveJpg()
    {
        $originalImage = imagecreatefromjpeg($this->get("originalFileModel")->getUrl());

        $viewImage = imagecreatetruecolor($this->_viewWidth, $this->_viewHeight);
        imagecopyresampled(
            $viewImage,
            $originalImage,
            0,
            0,
            0,
            0,
            $this->_viewWidth,
            $this->_viewHeight,
            $this->get("width"),
            $this->get("height")
        );
        imagejpeg($viewImage, $this->get("viewFileModel")->getTmpName());

        $thumbImage = imagecreatetruecolor($this->_thumbWidth, $this->_thumbHeight);
        imagecopyresampled(
            $thumbImage,
            $originalImage,
            0,
            0,
            0,
            0,
            $this->_thumbWidth,
            $this->_thumbHeight,
            $this->get("width"),
            $this->get("height")
        );
        imagejpeg($thumbImage, $this->get("thumbFileModel")->getTmpName());

        imagedestroy($originalImage);
        imagedestroy($viewImage);
        imagedestroy($thumbImage);

        return $this;
    }

    /**
     * Saves PNG
     *
     * @return ImageInstanceModel
     */
    private function _savePng()
    {
        $originalImage = imagecreatefrompng($this->get("originalFileModel")->getUrl());

        $viewImage = imagecreatetruecolor($this->_viewWidth, $this->_viewHeight);
        imagealphablending($viewImage, false);
        imagesavealpha($viewImage, true);
        $transparent = imagecolorallocatealpha($viewImage, 255, 255, 255, 127);
        imagefilledrectangle($viewImage, 0, 0, $this->get("width"), $this->get("height"), $transparent);
        imagecopyresampled(
            $viewImage,
            $originalImage,
            0,
            0,
            0,
            0,
            $this->_viewWidth,
            $this->_viewHeight,
            $this->get("width"),
            $this->get("height")
        );
        imagepng($viewImage, $this->get("viewFileModel")->getTmpName());

        $thumbImage = imagecreatetruecolor($this->_thumbWidth, $this->_thumbHeight);
        imagealphablending($thumbImage, false);
        imagesavealpha($thumbImage, true);
        $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
        imagefilledrectangle($thumbImage, 0, 0, $this->get("width"), $this->get("height"), $transparent);
        imagecopyresampled(
            $thumbImage,
            $originalImage,
            0,
            0,
            0,
            0,
            $this->_thumbWidth,
            $this->_thumbHeight,
            $this->get("width"),
            $this->get("height")
        );
        imagepng($thumbImage, $this->get("thumbFileModel")->getTmpName());

        imagedestroy($originalImage);
        imagedestroy($viewImage);
        imagedestroy($thumbImage);

        return $this;
    }
}