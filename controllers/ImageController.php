<?php

namespace testS\controllers;

use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\ValueGenerator;
use testS\models\BlockModel;
use testS\models\FileModel;
use testS\models\ImageInstanceModel;
use testS\models\ImageModel;

/**
 * ImageController
 *
 * @package testS\controllers
 */
class ImageController extends AbstractController
{

    /**
     * Gets a list of blocks
     *
     * @return array
     */
    public function getBlocks()
    {
        $this->checkUser();

        $blockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_IMAGE)
            ->byLanguage(Language::getActiveId())
            ->bySectionId($this->getDisplayBlocksFromSection())
            ->findAll();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $list[] = [
                "name"              => $blockModel->get("name"),
                "id"                => $blockModel->getId(),
                "canUpdateSettings" => $canUpdateSettings,
                "canUpdateDesign"   => $canUpdateDesign,
                "canUpdateContent"  => $canUpdateContent
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_IMAGE,
            Operation::ALL,
            Operation::IMAGE_ADD
        );

        return [
            "title"       => Language::t("image", "images"),
            "description" => Language::t("image", "panelDescription"),
            "list"        => $list,
            "back"        => [
                "controller" => "block",
                "action"     => "blocks"
            ],
            "settings"    => [
                "controller" => "image",
                "action"     => "block"
            ],
            "design"      => [
                "controller" => "image",
                "action"     => "design"
            ],
            "content"     => [
                "controller" => "image",
                "action"     => "content"
            ],
            "canAdd"      => $canAdd,
        ];
    }

    /**
     * Gets block
     *
     * @return array
     */
    public function getBlock()
    {
        $id = (int)$this->get("id");

        if ($id === 0) {
            $this->checkBlockOperation(BlockModel::TYPE_IMAGE, Operation::ALL, Operation::IMAGE_ADD);

            $blockModel = new BlockModel();
            $name = "";

            $type = ImageModel::TYPE_ZOOM;
            $autoCropType = ImageModel::AUTO_CROP_TYPE_NONE;
            $cropWidth = 0;
            $cropHeight = 0;
            $cropX = 0;
            $cropY = 0;
            $thumbAutoCropType = ImageModel::AUTO_CROP_TYPE_NONE;
            $thumbCropX = 0;
            $thumbCropY = 0;
            $useAlbums = false;
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $id, Operation::IMAGE_UPDATE_SETTINGS);

            $blockModel = BlockModel::getById($id);
            $name = $blockModel->get("name");

            $imageModel = $blockModel->getContentModel();
            $type = $imageModel->get("type");
            $autoCropType = $imageModel->get("autoCropType");
            $cropWidth = $imageModel->get("cropWidth");
            $cropHeight = $imageModel->get("cropHeight");
            $cropX = $imageModel->get("cropX");
            $cropY = $imageModel->get("cropY");
            $thumbAutoCropType = $imageModel->get("thumbAutoCropType");
            $thumbCropX = $imageModel->get("thumbCropX");
            $thumbCropY = $imageModel->get("thumbCropY");
            $useAlbums = $imageModel->get("useAlbums");
        }

        return [
            "id"          => $id,
            "title"       => Language::t(
                "image",
                $id === 0 ? "addBlockTitle" : "editBlockTitle"
            ),
            "description" => Language::t(
                "image",
                $id === 0 ? "addBlockDescription" : "editBlockDescription"
            ),
            "forms"       => [
                "name"              => [
                    "name"       => "name",
                    "label"      => Language::t("common", "name"),
                    "validation" => $blockModel->getValidationRulesForField("name"),
                    "value"      => $name,
                ],
                "type"              => [
                    "label" => Language::t("common", "type"),
                    "value" => $type,
                    "name"  => "type",
                    "list"  => ValueGenerator::generate(ValueGenerator::ORDERED_ARRAY, ImageModel::getTypeList())
                ],
                "autoCropType"      => [
                    "label" => Language::t("image", "autoCropType"),
                    "value" => $autoCropType,
                    "name"  => "autoCropType",
                    "list"  => ImageModel::getAutoCropTypeList()
                ],
                "cropWidth"         => [
                    "name"  => "cropWidth",
                    "label" => Language::t("image", "cropWidth"),
                    "value" => $cropWidth,
                ],
                "cropHeight"        => [
                    "name"  => "cropHeight",
                    "label" => Language::t("image", "cropHeight"),
                    "value" => $cropHeight,
                ],
                "cropX"             => [
                    "name"  => "cropX",
                    "label" => Language::t("image", "cropX"),
                    "value" => $cropX,
                ],
                "cropY"             => [
                    "name"  => "cropY",
                    "label" => Language::t("image", "cropY"),
                    "value" => $cropY,
                ],
                "thumbAutoCropType" => [
                    "label" => Language::t("image", "thumbAutoCropType"),
                    "value" => $thumbAutoCropType,
                    "name"  => "thumbAutoCropType",
                    "list"  => ImageModel::getAutoCropTypeList()
                ],
                "useAlbums"         => [
                    "name"  => "useAlbums",
                    "label" => Language::t("image", "useAlbums"),
                    "value" => $useAlbums,
                ],
                "thumbCropX"        => [
                    "name"  => "thumbCropX",
                    "label" => Language::t("image", "thumbCropX"),
                    "value" => $thumbCropX,
                ],
                "thumbCropY"        => [
                    "name"  => "thumbCropY",
                    "label" => Language::t("image", "thumbCropY"),
                    "value" => $thumbCropY,
                ],
                "button"            => [
                    "label" => Language::t("common", $id === 0 ? "add" : "update"),
                ]
            ]
        ];
    }

    /**
     * Adds block
     */
    public function createBlock()
    {
        // @TODO
    }

    /**
     * Updates block
     */
    public function updateBlock()
    {
        // @TODO
    }

    /**
     * Deletes block
     */
    public function deleteBlock()
    {
        // @TODO
    }

    /**
     * Gets block's design
     */
    public function getDesign()
    {
        // @TODO
    }

    /**
     * Updates block's design
     */
    public function updateDesign()
    {
        // @TODO
    }

    /**
     * Gets block's content
     */
    public function getContent()
    {
        // @TODO
    }

    /**
     * Updates block's content
     */
    public function updateContent()
    {
        // @TODO
    }

    /**
     * Gets image
     *
     * @throws NotFoundException
     *
     * @return array
     */
    public function getImage()
    {
        $this->checkData(
            [
                "blockId" => [self::NOT_EMPTY],
                "id"      => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPDATE);

        $imageInstanceModel = (new ImageInstanceModel())->byId($this->get("id"))->withRelations()->find();
        if (!$imageInstanceModel instanceof ImageInstanceModel) {
            throw new NotFoundException(
                "Unable to find ImageInstanceModel by ID: {id}",
                [
                    "id" => $this->get("id")
                ]
            );
        }

        $fileModel = $imageInstanceModel->get("originalFileModel");
        if (!$fileModel instanceof FileModel) {
            throw new NotFoundException(
                "Unable to get original FileModel for ImageInstanceModel with ID: {id}",
                [
                    "id" => $this->get("id")
                ]
            );
        }

        return [
            "url"     => $fileModel->getUrl(),
            "alt"     => $imageInstanceModel->get("alt"),
            "width"   => $imageInstanceModel->get("width"),
            "height"  => $imageInstanceModel->get("height"),
            "x1"      => $imageInstanceModel->get("x1"),
            "y1"      => $imageInstanceModel->get("y1"),
            "x2"      => $imageInstanceModel->get("x2"),
            "y2"      => $imageInstanceModel->get("y2"),
            "thumbX1" => $imageInstanceModel->get("thumbX1"),
            "thumbY1" => $imageInstanceModel->get("thumbY1"),
            "thumbX2" => $imageInstanceModel->get("thumbX2"),
            "thumbY2" => $imageInstanceModel->get("thumbY2"),
        ];
    }

    /**
     * Creates an image
     *
     * @return array
     */
    public function createImage()
    {
        $this->checkData(
            [
                "blockId"      => [self::NOT_EMPTY],
                "imageAlbumId" => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPLOAD);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(["imageAlbumId" => $this->get("imageAlbumId")]);

        return $imageInstanceModel->upload();
    }

    /**
     * Update image
     */
    public function updateImage()
    {
        //        $this->checkData(
        //            [
        //                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
        //                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
        //                "alt"     => [self::TYPE_STRING],
        //                "x1"      => [self::TYPE_INT],
        //                "y1"      => [self::TYPE_INT],
        //                "x2"      => [self::TYPE_INT],
        //                "y2"      => [self::TYPE_INT],
        //                "thumbX1" => [self::TYPE_INT],
        //                "thumbY1" => [self::TYPE_INT],
        //                "thumbX2" => [self::TYPE_INT],
        //                "thumbY2" => [self::TYPE_INT],
        //                "angle"   => [self::TYPE_INT],
        //                "flip"    => [self::TYPE_INT],
        //            ]
        //        );
        //
        //        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPDATE);
        //
        //        $imageInstanceModel = (new ImageInstanceModel())->byId($this->get("id"))->withRelations()->find();
        //        if (!$imageInstanceModel instanceof ImageInstanceModel) {
        //            throw new NotFoundException(
        //                "Unable to find ImageInstanceModel by ID: {id}",
        //                [
        //                    "id" => $this->get("id")
        //                ]
        //            );
        //        }
        //
        //        $imageInstanceModel->set(
        //            [
        //                "alt"     => $this->get("alt"),
        //                "x1"      => $this->get("x1"),
        //                "y1"      => $this->get("y1"),
        //                "x2"      => $this->get("x2"),
        //                "y2"      => $this->get("y2"),
        //                "thumbX1" => $this->get("thumbX1"),
        //                "thumbY1" => $this->get("thumbY1"),
        //                "thumbX2" => $this->get("thumbX2"),
        //                "thumbY2" => $this->get("thumbY2"),
        //                "angle"   => $this->get("angle"),
        //                "flip"    => $this->get("flip"),
        //            ]
        //        );
        //
        //        return $imageInstanceModel->update();
    }

    /**
     * Deletes the image
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function deleteImage()
    {
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPLOAD);

        $imageInstanceModel = (new ImageInstanceModel())->byId($this->get("id"))->find();
        if (!$imageInstanceModel instanceof ImageInstanceModel) {
            throw new NotFoundException(
                "Unable to find ImageInstanceModel by ID: {id}",
                [
                    "id" => $this->get("id")
                ]
            );
        }

        $imageInstanceModel->delete();

        return [
            "result" => true
        ];
    }

    /**
     * Gets album
     */
    public function getAlbum()
    {
        // @TODO
    }

    /**
     * Add album
     */
    public function createAlbum()
    {
        // @TODO
    }

    /**
     * Update album
     */
    public function updateAlbum()
    {
        // @TODO
    }

    /**
     * Delete album
     */
    public function deleteAlbum()
    {
        // @TODO
    }
}