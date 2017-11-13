<?php

namespace testS\models;

use testS\components\exceptions\FileException;
use testS\components\Language;
use testS\components\ValueGenerator;
use Gregwar\Image\Image;

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

    // Extensions
    const EXT_JPG = "jpg";
    const EXT_PNG = "png";

    // Flips
    const FLIP_NONE = 0;
    const FLIP_HORIZONTAL = 1;
    const FLIP_VERTICAL = 2;
    const FLIP_BOTH = 3;

    /**
     * Original file model
     *
     * @var FileModel
     */
    private $_originalFileModel = null;

    /**
     * View file model
     *
     * @var FileModel
     */
    private $_viewFileModel = null;

    /**
     * Thumb file model
     *
     * @var FileModel
     */
    private $_thumbFileModel = null;

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
     * Gets type list
     *
     * @return array
     */
    public static function getFlipList()
    {
        return [
            self::FLIP_NONE       => Language::t("image", "flipNone"),
            self::FLIP_HORIZONTAL => Language::t("image", "flipHorizontal"),
            self::FLIP_VERTICAL   => Language::t("image", "flipVertical"),
            self::FLIP_BOTH       => Language::t("image", "flipBoth"),
        ];
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
    public function getFieldsInfo()
    {
        return [
            "imageAlbumId"   => [
                self::FIELD_RELATION_TO_PARENT => "ImageGroupModel",
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            "originalFileId" => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "viewFileId"     => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbFileId"    => [
                self::FIELD_RELATION         => "FileModel",
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "isCover"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "sort"           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "alt"            => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "width"          => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "height"         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x1"             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y1"             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "x2"             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "y2"             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::VIEW_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX1"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY1"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbX2"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "thumbY2"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::THUMB_MAX_SIZE
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "angle"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "flip"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getFlipList(), self::FLIP_NONE]
                ],
            ],
        ];
    }

    public function upload()
    {
        $this
            ->_checkBeforeUpload()
            ->_setOriginalFileModelFromUploadedFile()
            ->_setParametersForUploadedFile()
            ->_setNewFileModels()
            ->_uploadOriginalFile()
            ->_createTmpViewImageToUpload()
            ->_createTmpThumbImageToUpload()
            ->_uploadViewFile()
            ->_uploadThumbFile()
            ->_save();

        return [
            "originalUrl" => $this->get("originalFileModel")->getUrl(),
            "viewUrl"     => $this->get("viewFileModel")->getUrl(),
            "thumbUrl"    => $this->get("thumbFileModel")->getUrl(),
            "name"        => str_replace(
                sprintf(".%s", $this->_extension),
                "",
                $this->get("originalFileModel")->get("originalName")
            ),
            "id"          => $this->getId()
        ];
    }

    /**
     * Checks before upload
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _checkBeforeUpload()
    {
        if ($this->get("imageAlbumId") === 0) {
            throw new FileException("Unable to upload image because imageAlbumId is 0");
        }

        return $this;
    }

    /**
     * Sets original file model from uploaded file
     *
     * @return ImageInstanceModel
     */
    private function _setOriginalFileModelFromUploadedFile()
    {
        $this->_originalFileModel = (new FileModel())->parsePostRequest();
        return $this;
    }

    /**
     * Sets parameters for uploaded file
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _setParametersForUploadedFile()
    {
        $info = getimagesize($this->_originalFileModel->getTmpName());
        if (!is_array($info)) {
            throw new FileException(
                "Uploaded file: {file} is not an image",
                [
                    "file" => $this->_originalFileModel->get("originalName")
                ]
            );
        }

        if (!array_key_exists("mime", $info)) {
            throw new FileException(
                "Unable to get image mime. Info: {info}",
                [
                    "info" => json_encode($info)
                ]
            );
        }

        $this->set(
            [
                "width"  => $info[0],
                "height" => $info[1],
                "mime"   => $info["mime"]
            ]
        );

        $this
            ->_setExtension($info["mime"])
            ->_setSizes($info[0], $info[1]);

        return $this;
    }

    /**
     * Sets extension
     *
     * @param string $mime
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _setExtension($mime)
    {
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
     * @param int $originalWidth
     * @param int $originalHeight
     *
     * @return ImageInstanceModel
     */
    private function _setSizes($originalWidth, $originalHeight)
    {
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
     * Sets new file models
     *
     * @return ImageInstanceModel
     */
    private function _setNewFileModels()
    {
        $this->_originalFileModel->setUniqueName($this->_extension);

        $this->_viewFileModel = (new FileModel())
            ->generateTmpName()
            ->setUniqueName($this->_extension)
            ->set(
                [
                    "type" => $this->_originalFileModel->get("type")
                ]
            );

        $this->_thumbFileModel = (new FileModel())
            ->generateTmpName()
            ->setUniqueName($this->_extension)
            ->set(
                [
                    "type" => $this->_originalFileModel->get("type")
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
        $this->_originalFileModel->upload();
        return $this;
    }

    /**
     * Uploads view file
     *
     * @return ImageInstanceModel
     */
    private function _uploadViewFile()
    {
        $this->_viewFileModel->upload();
        return $this;
    }

    /**
     * Uploads thumb file
     *
     * @return ImageInstanceModel
     */
    private function _uploadThumbFile()
    {
        $this->_thumbFileModel->upload();
        return $this;
    }

    /**
     * Creates view tmp image to upload
     *
     * @return ImageInstanceModel
     */
    private function _createTmpViewImageToUpload()
    {
        Image
            ::open($this->_originalFileModel->getUrl())
            ->resize($this->_viewWidth, $this->_viewHeight)
            ->save($this->_viewFileModel->getTmpName());

        return $this;
    }

    /**
     * Creates thumb tmp image to upload
     *
     * @return ImageInstanceModel
     */
    private function _createTmpThumbImageToUpload()
    {
        Image
            ::open($this->_originalFileModel->getUrl())
            ->resize($this->_thumbWidth, $this->_thumbHeight)
            ->save($this->_thumbFileModel->getTmpName());

        return $this;
    }

    /**
     * Saves the model
     *
     * @return ImageInstanceModel
     */
    private function _save()
    {
        $this->set(
            [
                "originalFileModel" => $this->_originalFileModel,
                "viewFileModel"     => $this->_viewFileModel,
                "thumbFileModel"    => $this->_thumbFileModel,
            ]
        );

        $this->save();

        return $this;
    }

    /**
     * Updates the image
     *
     * @param array $data
     *
     * @return array
     */
    public function update(array $data)
    {
        $this
            ->_setSizes($this->get("width"), $this->get("height"))
            ->_updateView($data)
            ->_updateThumb($data)
            ->_updateImage($data);

        return [
            "originalUrl" => $this->get("originalFileModel")->getUrl(),
            "viewUrl"     => $this->get("viewFileModel")->getUrl(),
            "thumbUrl"    => $this->get("thumbFileModel")->getUrl(),
        ];
    }

    /**
     * Updates the view file
     *
     * @param array $data
     *
     * @return ImageInstanceModel
     */
    private function _updateView(array $data)
    {
        if ($data["x1"] === $this->get("x1")
            && $data["x2"] === $this->get("x2")
            && $data["y1"] === $this->get("y1")
            && $data["y2"] === $this->get("y2")
            && $data["angle"] === $this->get("angle")
            && $data["flip"] === $this->get("flip")
        ) {
            return $this;
        }

        $viewFileModel = $this->get("viewFileModel");

        $viewFileModel->generateTmpName();
        $viewFileModel->setUniqueName(
            trim(strtolower(pathinfo($viewFileModel->get("uniqueName"), PATHINFO_EXTENSION)))
        );

        $image = Image::open($this->get("originalFileModel")->getUrl());

        switch ($data["flip"]) {
            case self::FLIP_BOTH:
                $image->flip(true, true);
                break;
            case self::FLIP_HORIZONTAL:
                $image->flip(false, true);
                break;
            case self::FLIP_VERTICAL:
                $image->flip(true, false);
                break;
        }

        if ($data["angle"] !== 0) {
            $image->rotate($data["angle"]);
        }

        $image->crop($data["x1"], $data["y1"], $data["x2"] - $data["x1"], $data["y2"] - $data["y1"]);
        $image->resize($this->_viewWidth, $this->_viewHeight);
        $image->save($viewFileModel->getTmpName());

        $viewFileModel->save();

        return $this;
    }

    /**
     * Updates the thumb file
     *
     * @param array $data
     *
     * @return ImageInstanceModel
     */
    private function _updateThumb(array $data)
    {
        if ($data["thumbX1"] === $this->get("thumbX1")
            && $data["thumbX2"] === $this->get("thumbX2")
            && $data["thumbY1"] === $this->get("thumbY1")
            && $data["thumbY2"] === $this->get("thumbY2")
            && $data["angle"] === $this->get("angle")
            && $data["flip"] === $this->get("flip")
        ) {
            return $this;
        }

        $thumbFileModel = $this->get("viewFileModel");

        $thumbFileModel->generateTmpName();
        $thumbFileModel->setUniqueName(
            trim(strtolower(pathinfo($thumbFileModel->get("uniqueName"), PATHINFO_EXTENSION)))
        );

        $image = Image::open($this->get("originalFileModel")->getUrl());

        switch ($data["flip"]) {
            case self::FLIP_BOTH:
                $image->flip(true, true);
                break;
            case self::FLIP_HORIZONTAL:
                $image->flip(false, true);
                break;
            case self::FLIP_VERTICAL:
                $image->flip(true, false);
                break;
        }

        if ($data["angle"] !== 0) {
            $image->rotate($data["angle"]);
        }

        $image->crop(
            $data["thumbX1"],
            $data["thumbY1"],
            $data["thumbX2"] - $data["thumbX1"],
            $data["thumbY2"] - $data["thumbY1"]
        );
        $image->resize($this->_thumbWidth, $this->_thumbHeight);
        $image->save($thumbFileModel->getTmpName());

        $thumbFileModel->save();

        return $this;
    }

    /**
     * Updates the image
     *
     * @param array $data
     *
     * @return ImageInstanceModel
     */
    private function _updateImage(array $data)
    {
        if ($data["isCover"] !== $this->get("isCover")) {
            if ($data["isCover"] === true) {
                $this->updateMany(
                    ["isCover" => 0],
                    "imageAlbumId = :imageAlbumId",
                    ["imageAlbumId" => $this->get("imageAlbumId")]
                );
            }

            $this->set(["isCover" => $data["isCover"]]);
        }

        $this->set(["alt" => $data["alt"]]);
        $this->save();

        return $this;
    }
}