<?php

namespace testS\controllers;

use testS\models\FileModel;

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
        $fileModel = new FileModel();
        $fileModel->upload();

        return [
            "path" => $fileModel->getUrl()
        ];
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