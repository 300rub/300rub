<?php

namespace testS\tests\unit\controllers;

/**
 * Tests for the controller ImageController
 *
 * @package testS\tests\unit\controllers
 */
class ImageControllerTest extends AbstractControllerTest
{

    public function testGetHtml()
    {
        $this->markTestSkipped();
    }

    public function testGetBlocks()
    {
        $this->markTestSkipped();
    }

    public function testCreateBlock()
    {
        $this->markTestSkipped();
    }

    public function testUpdateBlock()
    {
        $this->markTestSkipped();
    }

    public function testDeleteBlock()
    {
        $this->markTestSkipped();
    }

    public function testGetDesign()
    {
        $this->markTestSkipped();
    }

    public function testUpdateDesign()
    {
        $this->markTestSkipped();
    }

    public function testGetContent()
    {
        $this->markTestSkipped();
    }

    public function testUpdateContent()
    {
        $this->markTestSkipped();
    }

    public function testGetImage()
    {
        $this->markTestSkipped();
    }

    public function testCreateImage()
    {
        //$this->markTestSkipped();

        $this->setUser(self::TYPE_FULL);
        $this->sendFile("image", "image", "bigImage.jpg", ["id" => 1, "imageAlbumId" => 1]);
        $body = $this->getBody();
        var_dump($body);
    }

    public function testUpdateImage()
    {
        $this->markTestSkipped();
    }

    public function testDeleteImage()
    {
        $this->markTestSkipped();
    }

    public function testGetAlbum()
    {
        $this->markTestSkipped();
    }

    public function testCreateAlbum()
    {
        $this->markTestSkipped();
    }

    public function testUpdateAlbum()
    {
        $this->markTestSkipped();
    }

    public function testDeleteAlbum()
    {
        $this->markTestSkipped();
    }
}