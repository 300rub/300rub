<?php

namespace testS\tests\unit\controllers;
use testS\applications\App;
use testS\models\ImageInstanceModel;

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

    /**
     * Test for createImage action
     *
     * @param string $user
     * @param string $file
     * @param int    $blockId
     * @param int    $albumId
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestCreateImage
     */
    public function testCreateImage($user, $file, $blockId, $albumId, $hasError = false)
    {
        $this->setUser($user);
        $this->sendFile("image", "image", $file, ["id" => $blockId, "imageAlbumId" => $albumId]);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $body = $this->getBody();

        $originalFileExplode = explode("/", $body["originalUrl"]);
        $originalFile = $originalFileExplode[count($originalFileExplode) - 1];
        $originalFilePath = sprintf(
            App::getInstance()->getConfig(["file", "pathMask"]),
            App::getInstance()->getSite()->getId(),
            $originalFile
        );
        $this->assertTrue(file_exists($originalFilePath));

        $viewFileExplode = explode("/", $body["viewUrl"]);
        $viewFile = $viewFileExplode[count($viewFileExplode) - 1];
        $viewFilePath = sprintf(
            App::getInstance()->getConfig(["file", "pathMask"]),
            App::getInstance()->getSite()->getId(),
            $viewFile
        );
        $this->assertTrue(file_exists($viewFilePath));

        $thumbFileExplode = explode("/", $body["thumbUrl"]);
        $thumbFile = $thumbFileExplode[count($thumbFileExplode) - 1];
        $thumbFilePath = sprintf(
            App::getInstance()->getConfig(["file", "pathMask"]),
            App::getInstance()->getSite()->getId(),
            $thumbFile
        );
        $this->assertTrue(file_exists($thumbFilePath));

        $imageInstanceModel = (new ImageInstanceModel())->byId($body["id"])->withRelations()->find();
        $this->assertNotNull($imageInstanceModel);

        $this->assertSame($originalFile, $imageInstanceModel->get("originalFileModel")->get("uniqueName"));
        $this->assertSame($viewFile, $imageInstanceModel->get("viewFileModel")->get("uniqueName"));
        $this->assertSame($thumbFile, $imageInstanceModel->get("thumbFileModel")->get("uniqueName"));

        $imageInstanceModel->delete();

        return true;
    }

    /**
     * Data provider for testCreateImage
     *
     * @return array
     */
    public function dataProviderForTestCreateImage()
    {
        return [
            "userJpgCorrect" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => false
            ],
            "userPngCorrect" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.png",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => false
            ],
            "userJpgIncorrectAlbumId" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 1,
                "albumId"  => 999,
                "hasError" => true
            ],
            "userJpgEmptyAlbumId" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 1,
                "albumId"  => 0,
                "hasError" => true
            ],
            "userIncorrectFormat" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "file.txt",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => true
            ],
            "blockedJpg" => [
                "user"     => self::TYPE_BLOCKED_USER,
                "file"     => "bigImage.jpg",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => true
            ],
            "blockedPng" => [
                "user"     => self::TYPE_BLOCKED_USER,
                "file"     => "bigImage.png",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => true
            ],
            "guestJpg" => [
                "user"     => null,
                "file"     => "bigImage.jpg",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => true
            ],
            "guestPng" => [
                "user"     => null,
                "file"     => "bigImage.png",
                "blockId"  => 1,
                "albumId"  => 1,
                "hasError" => true
            ],
        ];
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