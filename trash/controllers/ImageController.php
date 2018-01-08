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
     * Adds block
     *
     * @return array
     */
    public function createBlock()
    {
        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, Operation::ALL, Operation::IMAGE_ADD);

        $this->checkData(
            [
                "name"              => [self::TYPE_STRING],
                "type"              => [self::TYPE_INT],
                "autoCropType"      => [self::TYPE_INT],
                "cropWidth"         => [self::TYPE_INT],
                "cropHeight"        => [self::TYPE_INT],
                "cropX"             => [self::TYPE_INT],
                "cropY"             => [self::TYPE_INT],
                "thumbAutoCropType" => [self::TYPE_INT],
                "useAlbums"         => [self::TYPE_BOOL],
                "thumbCropX"        => [self::TYPE_INT],
                "thumbCropY"        => [self::TYPE_INT],
            ]
        );

        $imageModel = new ImageModel();
        $imageModel->set(
            [
                "type"              => $this->get("type"),
                "autoCropType"      => $this->get("autoCropType"),
                "cropWidth"         => $this->get("cropWidth"),
                "cropHeight"        => $this->get("cropHeight"),
                "cropX"             => $this->get("cropX"),
                "cropY"             => $this->get("cropY"),
                "thumbAutoCropType" => $this->get("thumbAutoCropType"),
                "useAlbums"         => $this->get("useAlbums"),
                "thumbCropX"        => $this->get("thumbCropX"),
                "thumbCropY"        => $this->get("thumbCropY"),
            ]
        );
        $imageModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => $this->get("name"),
                "language"    => Language::getActiveId(),
                "contentType" => BlockModel::TYPE_IMAGE,
                "contentId"   => $imageModel->getId(),
            ]
        );
        $blockModel->save();
        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Updates block
     *
     * @return array
     */
    public function updateBlock()
    {
        $this->checkData(
            [
                "id"                => [self::TYPE_INT, self::NOT_EMPTY],
                "name"              => [self::TYPE_STRING],
                "type"              => [self::TYPE_INT],
                "autoCropType"      => [self::TYPE_INT],
                "cropWidth"         => [self::TYPE_INT],
                "cropHeight"        => [self::TYPE_INT],
                "cropX"             => [self::TYPE_INT],
                "cropY"             => [self::TYPE_INT],
                "thumbAutoCropType" => [self::TYPE_INT],
                "useAlbums"         => [self::TYPE_BOOL],
                "thumbCropX"        => [self::TYPE_INT],
                "thumbCropY"        => [self::TYPE_INT],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_UPDATE_SETTINGS);

        $blockModel = BlockModel::getById($this->get("id"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");
        $imageModel->set(
            [
                "type"              => $this->get("type"),
                "autoCropType"      => $this->get("autoCropType"),
                "cropWidth"         => $this->get("cropWidth"),
                "cropHeight"        => $this->get("cropHeight"),
                "cropX"             => $this->get("cropX"),
                "cropY"             => $this->get("cropY"),
                "thumbAutoCropType" => $this->get("thumbAutoCropType"),
                "useAlbums"         => $this->get("useAlbums"),
                "thumbCropX"        => $this->get("thumbCropX"),
                "thumbCropY"        => $this->get("thumbCropY"),
            ]
        );
        $imageModel->save();

        $blockModel->set(
            [
                "name" => $this->get("name"),
            ]
        );
        $blockModel->save();

        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        $blockModel->setContent();

        return [
            "result" => true,
            "html"   => $blockModel->getHtml(),
            "css"    => $blockModel->getCss(),
            "js"     => $blockModel->getJs(),
        ];
    }

    /**
     * Deletes block
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function deleteBlock()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_DELETE);

        $blockModel = BlockModel::getById($this->get("id"));

        if ($blockModel->get("contentType") !== BlockModel::TYPE_IMAGE) {
            throw new BadRequestException(
                "Incorrect image block to delete. ID: {id}. Block type: {type}",
                [
                    "id"   => $this->get("id"),
                    "type" => $blockModel->get("contentType"),
                ]
            );
        }

        $blockModel->delete();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Duplicates block
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function createBlockDuplication()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_DUPLICATE);

        $blockModel = BlockModel::getById($this->get("id"));
        if ($blockModel->get("contentType") !== BlockModel::TYPE_IMAGE) {
            throw new BadRequestException(
                "Incorrect image block to duplicate. ID: {id}. Block type: {type}",
                [
                    "id"   => $this->get("id"),
                    "type" => $blockModel->get("contentType"),
                ]
            );
        }

        return [
            "id" => $blockModel->duplicate()->getId()
        ];
    }

    /**
     * Gets block's design
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function getDesign()
    {
        $this->checkData(
            [
                "id" => [self::NOT_EMPTY],
            ]
        );

        $id = (int)$this->get("id");

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $id, Operation::IMAGE_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($id);
        $imageModel = $blockModel->getContentModel(true, null, "ImageModel");

        $data = [
            $imageModel->get("designBlockModel")->getDesign(sprintf(".block-%s", $id))
        ];

        $cssSelector = sprintf(".image-%s", $imageModel->getId());
        switch ($imageModel->get("type")) {
            case ImageModel::TYPE_SIMPLE:
                $data = array_merge(
                    $data,
                    $imageModel->get("designImageSimpleModel")->getDesign($cssSelector)
                );
                break;
            case ImageModel::TYPE_SLIDER:
                $data = array_merge(
                    $data,
                    $imageModel->get("designImageSliderModel")->getDesign($cssSelector)
                );
                break;
            default:
                $data = array_merge(
                    $data,
                    $imageModel->get("designImageZoomModel")->getDesign($cssSelector)
                );
                break;
                break;
        }

        return [
            "id"          => $id,
            "controller"  => "image",
            "action"      => "design",
            "title"       => Language::t("image", "designTitle"),
            "description" => Language::t("image", "designDescription"),
            "list"        => [
                [
                    "title" => Language::t("image", "designTitle"),
                    "data"  => $data
                ]
            ],
            "button"      => [
                "label" => Language::t("common", "save"),
            ]
        ];
    }

    /**
     * Updates block's design
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateDesign()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($this->get("id"));

        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");

        $imageModel->set(
            [
                "designBlockModel" => $this->get("designBlockModel"),
            ]
        );

        if ($this->get("designImageZoomModel")) {
            $imageModel->set(
                [
                    "designImageZoomModel" => $this->get("designImageZoomModel"),
                ]
            );
        } elseif ($this->get("designImageSliderModel")) {
            $imageModel->set(
                [
                    "designImageSliderModel" => $this->get("designImageSliderModel"),
                ]
            );
        } elseif ($this->get("designImageSimpleModel")) {
            $imageModel->set(
                [
                    "designImageSimpleModel" => $this->get("designImageSimpleModel"),
                ]
            );
        } else {
            throw new BadRequestException(
                "Unable to find find designImageZoomModel or designImageSliderModel or designImageSimpleModel " .
                "in request to update design"
            );
        }

        $imageModel->save();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets block's content
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function getContent()
    {
        $this->checkData(
            [
                "id" => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($this->get("id"));
        $imageModel = $blockModel->getContentModel(false, null, "ImageModel");

        $list = [];
        $groupId = (int) $this->get("groupId");
        $data = [
            "labels" => []
        ];

        if ($imageModel->get("useAlbums") === true
            && !$groupId
        ) {
            $imageGroupModels = (new ImageGroupModel())->byImageId($imageModel->getId())->ordered("sort")->findAll();
            foreach ($imageGroupModels as $imageGroupModel) {
                $cover = (new ImageInstanceModel)->coverByGroupId($imageGroupModel->getId())->withRelations()->find();
                if ($cover !== null) {
                    $cover = [
                        "id"  => $cover->getId(),
                        "url" => $cover->get("thumbFileModel")->getUrl(),
                        "alt" => $cover->get("alt"),
                    ];
                }
                $list[] = [
                    "id"    => $imageGroupModel->getId(),
                    "name"  => $imageGroupModel->get("name"),
                    "cover" => $cover
                ];
            }

            return array_merge(
                $data,
                [
                    "useAlbums"      => true,
                    "canCreateAlbum" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_CREATE_ALBUM
                    ),
                    "canUpdateAlbum" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_UPDATE_ALBUM
                    ),
                    "canDeleteAlbum" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_DELETE_ALBUM
                    ),
                    "list"           => $list
                ]
            );
        } else {
            if ($imageModel->get("useAlbums") === true
                && $groupId
            ) {
                $imageInstanceModels = (new ImageInstanceModel())
                    ->byGroupId($groupId)
                    ->ordered("sort")
                    ->withRelations()
                    ->findAll();
            } else {
                $imageInstanceModels = (new ImageInstanceModel())
                    ->byImageId($imageModel->getId())
                    ->ordered("sort")
                    ->withRelations()
                    ->findAll();
            }

            foreach ($imageInstanceModels as $imageInstanceModel) {
                $list[] = [
                    "id"  => $imageInstanceModel->getId(),
                    "alt" => $imageInstanceModel->get("alt"),
                    "url" => $imageInstanceModel->get("thumbFileModel")->getUrl()
                ];
            }

            return array_merge(
                $data,
                [
                    "useAlbums"      => false,
                    "canUploadImage" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_UPLOAD
                    ),
                    "canUpdateImage" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_UPDATE
                    ),
                    "canDeleteImage" => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get("id"),
                        Operation::IMAGE_DELETE
                    ),
                    "list"           => $list
                ]
            );
        }
    }

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
        $this->checkData(
            [
                "blockId"      => [self::NOT_EMPTY],
                "imageGroupId" => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("blockId"), Operation::IMAGE_UPLOAD);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(["imageGroupId" => $this->get("imageGroupId")]);

        return $imageInstanceModel->upload();
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