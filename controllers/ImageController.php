<?php

namespace testS\controllers;

use testS\components\Operation;
use testS\models\BlockModel;
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
     */
    public function getImage()
    {
        // @TODO
    }

    /**
     * Add image
     */
    public function createImage()
    {
        $this->checkData(
            [
                "id"           => [self::NOT_EMPTY],
                "imageAlbumId" => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, $this->get("id"), Operation::IMAGE_UPLOAD);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(["imageAlbumId" => $this->get("imageAlbumId")]);

        return $imageInstanceModel->upload();
    }

    /**
     * Update image
     */
    public function updateImage()
    {
        // @TODO
    }

    /**
     * Delete image
     */
    public function deleteImage()
    {
        // @TODO
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