<?php

namespace testS\models;

use testS\components\exceptions\FileException;
use testS\components\Language;
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
     * Original image resource
     *
     * @var resource
     */
    private $_originalImage = null;

    /**
     * View image resource
     *
     * @var resource
     */
    private $_viewImage = null;

    /**
     * Thumb image resource
     *
     * @var resource
     */
    private $_thumbImage = null;

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
//
//    /**
//     * Is model changed flag
//     *
//     * @var bool
//     */
//    private $_isModelChanged = false;
//
//    /**
//     * Is view changed flag
//     *
//     * @var bool
//     */
//    private $_isViewChanged = false;
//
//    /**
//     * Is thumb changed flag
//     *
//     * @var bool
//     */
//    private $_isThumbChanged = false;

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
            "imageAlbumId"   => [
                self::FIELD_RELATION_TO_PARENT => "ImageGroupModel",
                self::FIELD_SKIP_DUPLICATION   => true,
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
            ->_destroyOriginalImage()
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
     * Gets original image
     *
     * @return resource
     *
     * @throws FileException
     */
    private function _getOriginalImage()
    {
        $url = $this->_originalFileModel->getUrl();

        if ($this->_originalImage === null) {
            switch ($this->_extension) {
                case self::EXT_JPG:
                    $this->_originalImage = imagecreatefromjpeg($url);
                    break;
                case self::EXT_PNG:
                    $this->_originalImage = imagecreatefrompng($url);
                    break;
            }
        }

        if ($this->_originalImage === null) {
            throw new FileException("Unable to create image from URL: {url}", ["url" => $url]);
        }

        return $this->_originalImage;
    }

    /**
     * Gets view image
     *
     * @return resource
     */
    private function _getViewImage()
    {
        if ($this->_viewImage === null) {
            $this->_viewImage = $this->_getOriginalImage();
        }

        return $this->_viewImage;
    }

    /**
     * Gets thumb image
     *
     * @return resource
     */
    private function _getThumbImage()
    {
        if ($this->_thumbImage === null) {
            $this->_thumbImage = $this->_getOriginalImage();
        }

        return $this->_thumbImage;
    }

    /**
     * Destroys original image
     *
     * @return ImageInstanceModel
     */
    private function _destroyOriginalImage()
    {
        if ($this->_originalImage !== null) {
            imagedestroy($this->_originalImage);
            $this->_originalImage = null;
        }

        return $this;
    }

    /**
     * Destroys view image
     *
     * @return ImageInstanceModel
     */
    private function _destroyViewImage()
    {
        if ($this->_viewImage !== null) {
            imagedestroy($this->_viewImage);
            $this->_viewImage = null;
        }

        return $this;
    }

    /**
     * Destroys thumb image
     *
     * @return ImageInstanceModel
     */
    private function _destroyThumbImage()
    {
        if ($this->_thumbImage !== null) {
            imagedestroy($this->_thumbImage);
            $this->_thumbImage = null;
        }

        return $this;
    }

    /**
     * Creates view tmp image to upload
     *
     * @return ImageInstanceModel
     */
    private function _createTmpViewImageToUpload()
    {
        $resource = $this->_getViewImage();

        $this
            ->_resize($resource, $this->_viewWidth, $this->_viewHeight)
            ->_saveImage($resource, $this->_viewFileModel->getTmpName())
            ->_destroyViewImage();

        imagedestroy($resource);

        return $this;
    }

    /**
     * Creates thumb tmp image to upload
     *
     * @return ImageInstanceModel
     */
    private function _createTmpThumbImageToUpload()
    {
        $resource = $this->_getThumbImage();

        $this
            ->_resize($resource, $this->_thumbWidth, $this->_thumbHeight)
            ->_saveImage($resource, $this->_thumbFileModel->getTmpName())
            ->_destroyThumbImage();

        imagedestroy($resource);

        return $this;
    }

    /**
     * Resize the image
     *
     * @param resource $resource
     * @param int      $width
     * @param int      $height
     *
     * @return ImageInstanceModel
     */
    private function _resize(&$resource, $width, $height)
    {
        $image = imagecreatetruecolor($width, $height);

        switch ($this->_extension) {
            case self::EXT_PNG:
                imagealphablending($image, false);
                imagesavealpha($image, true);
                $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
                imagefilledrectangle($image, 0, 0, $this->get("width"), $this->get("height"), $transparent);
                break;
        }

        imagecopyresampled(
            $image,
            $resource,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $this->get("width"),
            $this->get("height")
        );

        $resource = $image;

        imagedestroy($image);

        return $this;
    }

    /**
     * Saves the image
     *
     * @param resource $resource
     * @param string   $tmpName
     *
     * @return ImageInstanceModel
     *
     * @throws FileException
     */
    private function _saveImage($resource, $tmpName)
    {
        switch ($this->_extension) {
            case self::EXT_JPG:
                imagejpeg($resource, $tmpName);
                break;
            case self::EXT_PNG:
                imagepng($resource, $tmpName);
                break;
            default:
                throw new FileException(
                    "Unable to save image with extension: {extension}",
                    [
                        "extension" => $this->_extension
                    ]
                );
        }

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

//    /**
//     * Uploads the file
//     *
//     * @return array
//     */
//    public function upload()
//    {
//        $this
//            ->_checkImageAlbumId()
//            ->_setOriginalFileModel()
//            ->_setInfo()
//            ->_setExtension($this->_info["mime"])
//            ->_setSizes($this->_info[0], $this->_info[1])
//            ->_uploadOriginalFile()
//            ->_setViewFileModel()
//            ->_setThumbFileModel()
//            ->_uploadImage()
//            ->save();
//
//        return [
//            "originalUrl" => $this->get("originalFileModel")->getUrl(),
//            "viewUrl"     => $this->get("viewFileModel")->getUrl(),
//            "thumbUrl"    => $this->get("thumbFileModel")->getUrl(),
//            "name"        => str_replace(
//                sprintf(".%s", $this->_extension),
//                "",
//                $this->get("originalFileModel")->get("originalName")
//            ),
//            "id"          => $this->getId()
//        ];
//    }
//

//
//    /**
//     * Uploads view and thumb images
//     *
//     * @return ImageInstanceModel
//     *
//     * @throws FileException
//     */
//    private function _uploadImage()
//    {
//        $viewTmp = $this->get("viewFileModel")->getTmpName();
//        $this
//            ->_createImage()
//            ->_resize($this->_viewWidth, $this->_viewHeight)
//            ->_saveImage($viewTmp);
//        $this
//            ->get("viewFileModel")
//            ->setSizeFromTmpFile()
//            ->upload();
//
//        $thumbTmp = $this->get("thumbFileModel")->getTmpName();
//        $this
//            ->_createImage()
//            ->_resize($this->_thumbWidth, $this->_thumbHeight)
//            ->_saveImage($thumbTmp);
//        $this
//            ->get("thumbFileModel")
//            ->setSizeFromTmpFile()
//            ->upload();
//
//        return $this;
//    }
//

//

//

//

//

//

//

//
//    public function update()
//    {
//        $this->_setIsChanged();
//        if ($this->_isModelChanged === false
//            && $this->_isViewChanged === false
//            && $this->_isThumbChanged === false
//        ) {
//            return [
//                "isChanged" => false
//            ];
//        }
//
//        $this
//            ->_setExtension($this->get("originalFileModel")->get("type"))
//            ->_setSizes($this->get("width"), $this->get("height"));
//
//        if ($this->_isModelChanged === true) {
//            $this->save();
//        }
//
//
//        if ($this->_isViewChanged === true) {
//            $this->get("viewFileModel");
//            $this
//                ->_createImage()
//                ->_flip()
//                ->_rotate()
//                ->_crop($this->get("x1"), $this->get("y1"), $this->get("x2"), $this->get("y2"))
//                ->_resize($this->_viewWidth, $this->_viewHeight)
//                ->_saveImage("aaa");
//        }
//
//        $this->_destroyOriginalImage();
//
//        return [
//            "isChanged" => true
//        ];
//    }
//
//    private $_originalImage = null;
//    private $_image = null;
//
//    /**
//     * Sets isChanged flags
//     *
//     * @return ImageInstanceModel
//     */
//    private function _setIsChanged()
//    {
//        $currentImageInstanceModel = $this->byId($this->getId())->find();
//
//        if ($currentImageInstanceModel->get("alt") !== $this->get("alt")) {
//            $this->_isModelChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("x1") !== $this->get("x1")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("x2") !== $this->get("x2")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("y1") !== $this->get("y1")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("y2") !== $this->get("y2")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("thumbX1") !== $this->get("thumbX1")) {
//            $this->_isModelChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("thumbX2") !== $this->get("thumbX2")) {
//            $this->_isModelChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("thumbY1") !== $this->get("thumbY1")) {
//            $this->_isModelChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("thumbY2") !== $this->get("thumbY2")) {
//            $this->_isModelChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("angle") !== $this->get("angle")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        if ($currentImageInstanceModel->get("flip") !== $this->get("flip")) {
//            $this->_isModelChanged = true;
//            $this->_isViewChanged = true;
//            $this->_isThumbChanged = true;
//        }
//
//        return $this;
//    }
//
//    /**
//     * Creates an image
//     *
//     * @return ImageInstanceModel
//     *
//     * @throws FileException
//     */
//    private function _createImage()
//    {
//        if ($this->_originalImage === null) {
//            switch ($this->_extension) {
//                case self::EXT_JPG:
//                    $this->_originalImage = imagecreatefromjpeg($this->get("originalFileModel")->getUrl());
//                    break;
//                case self::EXT_PNG:
//                    $this->_originalImage = imagecreatefrompng($this->get("originalFileModel")->getUrl());
//                    break;
//                default:
//                    throw new FileException(
//                        "Unable to create image with extension: {extension}",
//                        [
//                            "extension" => $this->_extension
//                        ]
//                    );
//            }
//        }
//
//        $this->_image = $this->_originalImage;
//
//        return $this;
//    }
//

//
//    /**
//     * Flips the image
//     *
//     * @return ImageInstanceModel
//     */
//    private function _flip()
//    {
//        if ($this->get("flip") === self::FLIP_NONE) {
//            return $this;
//        }
//
//        switch ($this->get("flip")) {
//            case self::FLIP_HORIZONTAL:
//                $flip = IMG_FLIP_HORIZONTAL;
//                break;
//            case self::FLIP_VERTICAL:
//                $flip = IMG_FLIP_VERTICAL;
//                break;
//            case self::FLIP_BOTH:
//                $flip = IMG_FLIP_BOTH;
//                break;
//            default:
//                $flip = self::FLIP_NONE;
//        }
//
//        imageflip($this->_image, $flip);
//
//        return $this;
//    }
//
//    /**
//     * Rotates the image
//     *
//     * @return ImageInstanceModel
//     */
//    private function _rotate()
//    {
//        if ($this->get("angle") === 0) {
//            return $this;
//        }
//
//        $this->_image = imagerotate($this->_image, $this->get("angle"), 0);
//
//        return $this;
//    }
//
//    /**
//     * Crops the image
//     *
//     * @param int $x1
//     * @param int $y1
//     * @param int $x2
//     * @param int $y2
//     *
//     * @return ImageInstanceModel
//     *
//     * @throws FileException
//     */
//    private function _crop($x1, $y1, $x2, $y2)
//    {
//        if ($x1 === 0
//            && $y1 === 0
//            && $x2 === $this->get("width")
//            && $y2 === $this->get("height")
//        ) {
//            return $this;
//        }
//
//        $this->_image = imagecrop(
//            $this->_image,
//            [
//                'x' => $x1,
//                'y' => $y1,
//                'width' => $x2 - $x1,
//                'height' => $y2 - $y1
//            ]
//        );
//
//        if ($this->_image === false) {
//            throw new FileException("Unable to crop the image with ID: {id}", ["id" => $this->getId()]);
//        }
//
//        return $this;
//    }
//

//
//    /**
//     * Destroys the image
//     *
//     * @return ImageInstanceModel
//     *
//     * @throws FileException
//     */
//    private function _destroyOriginalImage()
//    {
//        if ($this->_originalImage !== null) {
//            imagedestroy($this->_originalImage);
//            $this->_originalImage = null;
//        }
//
//        return $this;
//    }
}