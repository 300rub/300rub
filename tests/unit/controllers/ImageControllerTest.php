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

    /**
     * Test for method getImage
     *
     * @param string $user
     * @param bool   $hasError
     * @param int    $id
     *
     * @dataProvider dataProviderForTestGetImage
     */
    public function testGetImage($user, $hasError = false, $id = null)
    {
        $this->setUser($user);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                "imageAlbumId"      => 1,
                "originalFileModel" => [
                    "uniqueName" => "new_file.jpg",
                ],
                "viewFileModel"     => [
                    "uniqueName" => "view_new_file.jpg",
                ],
                "thumbFileModel"    => [
                    "uniqueName" => "thumb_new_file.jpg",
                ],
                "alt"               => "Alt 1",
                "width"             => 800,
                "height"            => 600,
                "x1"                => 10,
                "y1"                => 30,
                "x2"                => 70,
                "y2"                => 80,
                "thumbX1"           => 5,
                "thumbY1"           => 15,
                "thumbX2"           => 35,
                "thumbY2"           => 45,
            ]
        );
        $imageInstanceModel->save();

        if ($id === null) {
            $id = $imageInstanceModel->getId();
        }

        $this->sendRequest("image", "image", ["blockId" => 3, "id" => $id]);

        if ($hasError === true) {
            $this->assertError();
        } else {
            $expected = [
                "url"     => "http://172.17.0.1/upload/1/new_file.jpg",
                "alt"     => "Alt 1",
                "width"   => 800,
                "height"  => 600,
                "x1"      => 10,
                "y1"      => 30,
                "x2"      => 70,
                "y2"      => 80,
                "thumbX1" => 5,
                "thumbY1" => 15,
                "thumbX2" => 35,
                "thumbY2" => 45,
            ];
            $this->compareExpectedAndActual($expected, $this->getBody());
        }

        $imageInstanceModel->delete();
    }

    /**
     * Data provider for testGetImage
     *
     * @return array
     */
    public function dataProviderForTestGetImage()
    {
        return [
            "admin"                => [
                "user"     => self::TYPE_FULL,
                "hasError" => false,
                "id"       => null
            ],
            "adminIncorrectId"     => [
                "user"     => self::TYPE_FULL,
                "hasError" => true,
                "id"       => 9999
            ],
            "adminIncorrectFormat" => [
                "user"     => self::TYPE_FULL,
                "hasError" => true,
                "id"       => "1"
            ],
            "limited"              => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => false,
                "id"       => null
            ],
            "guest"                => [
                "user"     => null,
                "hasError" => true,
                "id"       => null
            ],
            "blocked"              => [
                "user"     => self::TYPE_BLOCKED_USER,
                "hasError" => true,
                "id"       => null
            ],
        ];
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
        $this->sendFile("image", "image", $file, ["blockId" => $blockId, "imageAlbumId" => $albumId]);

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
            "userJpgCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => false
            ],
            "userPngCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.png",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => false
            ],
            "userJpgIncorrectAlbumId" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 3,
                "albumId"  => 999,
                "hasError" => true
            ],
            "userJpgEmptyAlbumId"     => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                "blockId"  => 3,
                "albumId"  => 0,
                "hasError" => true
            ],
            "userIncorrectFormat"     => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "file.txt",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => true
            ],
            "blockedJpg"              => [
                "user"     => self::TYPE_BLOCKED_USER,
                "file"     => "bigImage.jpg",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => true
            ],
            "blockedPng"              => [
                "user"     => self::TYPE_BLOCKED_USER,
                "file"     => "bigImage.png",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => true
            ],
            "guestJpg"                => [
                "user"     => null,
                "file"     => "bigImage.jpg",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => true
            ],
            "guestPng"                => [
                "user"     => null,
                "file"     => "bigImage.png",
                "blockId"  => 3,
                "albumId"  => 1,
                "hasError" => true
            ],
        ];
    }

    public function testUpdateImage()
    {
        $this->markTestSkipped();
    }

    /**
     * Test for method deleteImage
     *
     * @param string $user
     * @param bool   $hasError
     * @param int    $id
     *
     * @dataProvider dataProviderForTestDeleteImage
     */
    public function testDeleteImage($user, $hasError = false, $id = null)
    {
        $this->setUser($user);

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                "imageAlbumId"      => 1,
                "originalFileModel" => [
                    "uniqueName" => "new_file.jpg",
                ],
                "viewFileModel"     => [
                    "uniqueName" => "view_new_file.jpg",
                ],
                "thumbFileModel"    => [
                    "uniqueName" => "thumb_new_file.jpg",
                ],
            ]
        );
        $imageInstanceModel->save();

        if ($id === null) {
            $id = $imageInstanceModel->getId();
        }

        $this->sendRequest("image", "image", ["blockId" => 3, "id" => $id], "DELETE");

        if ($hasError === true) {
            $this->assertError();
            $this->assertNotNull($imageInstanceModel->byId($imageInstanceModel->getId())->find());
            $imageInstanceModel->delete();
        } else {
            $expected = [
                "result" => true
            ];
            $this->assertSame($expected, $this->getBody());
            $this->assertNull($imageInstanceModel->byId($imageInstanceModel->getId())->find());
        }
    }

    /**
     * Data provider for testDeleteImage
     *
     * @return array
     */
    public function dataProviderForTestDeleteImage()
    {
        return [
            "admin"                => [
                "user"     => self::TYPE_FULL,
                "hasError" => false,
                "id"       => null
            ],
            "adminIncorrectId"     => [
                "user"     => self::TYPE_FULL,
                "hasError" => true,
                "id"       => 9999
            ],
            "adminIncorrectFormat" => [
                "user"     => self::TYPE_FULL,
                "hasError" => true,
                "id"       => "1"
            ],
            "limited"              => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => false,
                "id"       => null
            ],
            "guest"                => [
                "user"     => null,
                "hasError" => true,
                "id"       => null
            ],
            "blocked"              => [
                "user"     => self::TYPE_BLOCKED_USER,
                "hasError" => true,
                "id"       => null
            ],
        ];
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