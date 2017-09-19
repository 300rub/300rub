<?php

namespace testS\controllers;

use testS\components\exceptions\NotFoundException;
use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\FileModel;
use testS\models\ImageInstanceModel;

/**
 * ImageController
 *
 * @package testS\controllers
 */
class ImageController extends AbstractController
{

    /**
     * Gets block's HTML
     */
    public function getHtml()
    {
        // @TODO
    }

    /**
     * Gets a list of blocks
     */
    public function getBlocks()
    {
        // @TODO
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
        $this->checkData(
            [
                "blockId" => [self::TYPE_INT, self::NOT_EMPTY],
                "id"      => [self::TYPE_INT, self::NOT_EMPTY],
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

        $imageInstanceModel->set(
            [
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
            ]
        );

        return $imageInstanceModel->update();
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