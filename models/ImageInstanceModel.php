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

    // Mimes
    const MIME_JPG = "image/jpeg";

    // Extensions
    const EXT_JPG = "jpg";

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
            "fileId"       => [
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

    public function upload()
    {
        $originalFileModel = new FileModel();
        $originalFileModel->parsePostRequest();

        $info = getimagesize($originalFileModel->getTmpName());
        if (!is_array($info)) {
            throw new FileException(
                "Uploaded file: {file} is not an image",
                [
                    "file" => $originalFileModel->get("originalName")
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

        switch ($info["mime"]) {
            case self::MIME_JPG:
                $extension = self::EXT_JPG;
                break;
            default:
                throw new FileException(
                    "Unable to upload image with mime: {mime}",
                    [
                        "mime" => $info["mime"]
                    ]
                );
        }

        $originalFileUrl = $originalFileModel
            ->setUniqueName($extension)
            ->upload()
            ->getUrl();

        $viewFileModel = new FileModel();
        $viewFileModel
            ->generateTmpName()
            ->set(
                [
                    "uniqueName" => self::VIEW_PREFIX . $originalFileModel->get("uniqueName"),
                    "type"       => $originalFileModel->get("type")
                ]
            );

        $thumbFileModel = new FileModel();
        $thumbFileModel
            ->generateTmpName()
            ->set(
                [
                    "uniqueName" => self::THUMB_PREFIX . $originalFileModel->get("uniqueName"),
                    "type"       => $originalFileModel->get("type")
                ]
            );

        list($originalWidth, $originalHeight) = $info;

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

        switch ($extension) {
            case self::EXT_JPG:
                $originalImage = imagecreatefromjpeg($originalFileUrl);

                $viewImage = imagecreatetruecolor($viewWidth, $viewHeight);
                imagecopyresampled(
                    $viewImage,
                    $originalImage,
                    0,
                    0,
                    0,
                    0,
                    $viewWidth,
                    $viewHeight,
                    $originalWidth,
                    $originalHeight
                );
                imagejpeg($viewImage, $viewFileModel->getTmpName());

                $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
                imagecopyresampled(
                    $thumbImage,
                    $originalImage,
                    0,
                    0,
                    0,
                    0,
                    $thumbWidth,
                    $thumbHeight,
                    $originalWidth,
                    $originalHeight
                );
                imagejpeg($thumbImage, $thumbFileModel->getTmpName());

                break;
            default:
                throw new FileException(
                    "Unable to upload image with extension: {extension}",
                    [
                        "extension" => $extension
                    ]
                );
        }

        imagedestroy($originalImage);
        imagedestroy($viewImage);
        imagedestroy($thumbImage);

        $viewFileModel->setSizeFromTmpFile()->upload();
        $thumbFileModel->setSizeFromTmpFile()->upload();

        $originalFileModel->save();

        return $originalFileModel->getUrl();
    }
}