<?php

namespace testS\controllers;

use testS\components\exceptions\BadRequestException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\ValueGenerator;
use testS\models\AbstractModel;
use testS\models\BlockModel;
use testS\models\FileModel;
use testS\models\ImageGroupModel;
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
     * Updates block's content
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function updateContent()
    {
        $this->checkData(
            [
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
                "groupId" => [self::TYPE_INT],
                "list"    => [self::TYPE_ARRAY]
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($this->get("id"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");

        if ($imageModel->get("useAlbums")) {
            $groupId = $this->get("groupId");

            if ($groupId === 0) {
                $models = $imageInstanceModels = (new ImageGroupModel())
                    ->byImageId($imageModel->getId())
                    ->findAll();
            } else {
                $models = (new ImageInstanceModel())
                    ->byGroupId($groupId)
                    ->findAll();
            }
        } else {
            $models = $imageInstanceModels = (new ImageInstanceModel())
                ->byImageId($imageModel->getId())
                ->findAll();
        }

        $modelList = [];
        foreach ($models as $model) {
            $modelList[$model->getId()] = $model;
        }

        $list = $this->get("list");
        $sort = 10;
        foreach ($list as $item) {
            if (!array_key_exists($item, $modelList)) {
                throw new BadRequestException(
                    "Unable to find model with ID: {id}",
                    [
                        "id" => $item,
                    ]
                );
            }

            /**
             * @var AbstractModel $model
             */
            $model = $modelList[$item];
            $model
                ->set(["sort" => $sort])
                ->save();

            $sort += 10;
        }

        return $this->getSimpleSuccessResult();
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

    }

    /**
     * Update image
     */
    public function updateImage()
    {
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
                "isCover" => [self::TYPE_BOOL],
                "alt"     => [self::TYPE_STRING],
                "x1"      => [self::TYPE_INT],
                "y1"      => [self::TYPE_INT],
                "x2"      => [self::TYPE_INT],
                "y2"      => [self::TYPE_INT],
                "thumbX1" => [self::TYPE_INT],
                "thumbY1" => [self::TYPE_INT],
                "thumbX2" => [self::TYPE_INT],
                "thumbY2" => [self::TYPE_INT],
                "angle"   => [self::TYPE_INT],
                "flip"    => [self::TYPE_INT],
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

        $data = [
            "isCover" => $this->get("isCover"),
            "alt"     => $this->get("alt"),
            "x1"      => $this->get("x1"),
            "y1"      => $this->get("y1"),
            "x2"      => $this->get("x2"),
            "y2"      => $this->get("y2"),
            "thumbX1" => $this->get("thumbX1"),
            "thumbY1" => $this->get("thumbY1"),
            "thumbX2" => $this->get("thumbX2"),
            "thumbY2" => $this->get("thumbY2"),
            "angle"   => $this->get("angle"),
            "flip"    => $this->get("flip"),
        ];

        return $imageInstanceModel->update($data);
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
     *
     * @throws NotFoundException
     *
     * @return array
     */
    public function getAlbum()
    {
        $this->checkData(
            [
                "blockId" => [self::NOT_EMPTY],
            ]
        );

        $id = (int)$this->get("id");
        $blockId = (int)$this->get("blockId");

        if ($id === 0) {
            $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $blockId, Operation::IMAGE_CREATE_ALBUM);
            $imageGroupModel = new ImageGroupModel();
            $name = "";
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $blockId, Operation::IMAGE_UPDATE_ALBUM);

            $blockModel = BlockModel::getById($this->get("blockId"));
            $imageModel = $blockModel->getContentModel(false, null, "ImageModel");
            $imageGroupModel = (new ImageGroupModel())->byImageId($imageModel->getId())->byId($id)->find();

            if ($imageGroupModel === null) {
                throw new NotFoundException(
                    "Unable to find ImageGroupModel by ID: {id} and blockId: {blockId} and imageId: {imageId}",
                    [
                        "id"      => $id,
                        "blockId" => $blockModel->get(),
                        "imageId" => $imageModel->getId(),
                    ]
                );
            }

            $name = $imageGroupModel->get("name");
        }

        return [
            "blockId" => $blockId,
            "id"      => $id,
            "title"   => Language::t(
                "image",
                $id === 0 ? "createAlbum" : "updateAlbum"
            ),
            "forms"   => [
                "name"   => [
                    "name"       => "name",
                    "label"      => Language::t("common", "name"),
                    "validation" => $imageGroupModel->getValidationRulesForField("name"),
                    "value"      => $name,
                ],
                "button" => [
                    "label" => Language::t("common", $id === 0 ? "add" : "update"),
                ]
            ]
        ];
    }

    /**
     * Creates an album
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function createAlbum()
    {
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "name"    => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_CREATE_ALBUM);

        $blockModel = BlockModel::getById($this->get("blockId"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                "imageId" => $imageModel->getId(),
                "name"    => $this->get("name"),
                "sort"    => 10000,
            ]
        );
        $imageGroupModel->save();

        $errors = $imageGroupModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Updates album
     *
     * @throws NotFoundException
     *
     * @return array
     */
    public function updateAlbum()
    {
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
                "name"    => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPDATE_ALBUM);

        $blockModel = BlockModel::getById($this->get("blockId"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");
        $imageGroupModel = (new ImageGroupModel())->byImageId($imageModel->getId())->byId($this->get("id"))->find();

        if ($imageGroupModel === null) {
            throw new NotFoundException(
                "Unable to find ImageGroupModel by ID: {id} and blockId: {blockId} and imageId: {imageId}",
                [
                    "id"      => $this->get("id"),
                    "blockId" => $blockModel->get(),
                    "imageId" => $imageModel->getId(),
                ]
            );
        }

        $imageGroupModel->set(
            [
                "name" => $this->get("name"),
            ]
        );
        $imageGroupModel->save();

        $errors = $imageGroupModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Delete album
     *
     * @throws NotFoundException
     *
     * @return array
     */
    public function deleteAlbum()
    {
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_DELETE_ALBUM);

        $blockModel = BlockModel::getById($this->get("blockId"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");
        $imageGroupModel = (new ImageGroupModel())->byImageId($imageModel->getId())->byId($this->get("id"))->find();

        if ($imageGroupModel === null) {
            throw new NotFoundException(
                "Unable to find ImageGroupModel by ID: {id} and blockId: {blockId} and imageId: {imageId}",
                [
                    "id"      => $this->get("id"),
                    "blockId" => $blockModel->getId(),
                    "imageId" => $imageModel->getId(),
                ]
            );
        }

        $imageGroupModel->delete();

        return $this->getSimpleSuccessResult();
    }
}