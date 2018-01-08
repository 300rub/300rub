<?php

namespace testS\tests\unit\controllers;

use testS\application\App;
use testS\models\BlockModel;
use testS\models\ImageGroupModel;
use testS\models\ImageInstanceModel;
use testS\models\ImageModel;

/**
 * Tests for the controller ImageController
 *
 * @package testS\tests\unit\controllers
 */
class ImageControllerTest extends AbstractControllerTest
{






    /**
     * Test for method updateContent
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateContent
     */
    public function testUpdateContent($user, $data, $hasError)
    {
        $this->setUser($user);

        $this->sendRequest("image", "content", $data, "PUT");

        if ($hasError === true) {
            $this->assertError();
            return true;
        }
        
        $this->assertSame(
            [
                "result" => true
            ],
            $this->getBody()
        );

        return true;
    }

    /**
     * Data provider for testUpdateContent
     *
     * @return array
     */
    public function dataProviderForTestUpdateContent()
    {
        return [
            "userUpdateAlbums" => [
                "user"     => self::TYPE_LIMITED,
                "data"     => [
                    "id"      => 4,
                    "groupId" => 0,
                    "list"    => [2, 3],
                ],
                "hasError" => false,
            ],
            "userUpdateImages" => [
                "user"     => self::TYPE_LIMITED,
                "data"     => [
                    "id"      => 3,
                    "groupId" => 0,
                    "list"    => [1, 2],
                ],
                "hasError" => false,
            ],
            "userUpdateAlbum" => [
                "user"     => self::TYPE_LIMITED,
                "data"     => [
                    "id"      => 3,
                    "groupId" => 1,
                    "list"    => [1, 2],
                ],
                "hasError" => false,
            ],
            "userUpdateAlbumIncorrect" => [
                "user"     => self::TYPE_LIMITED,
                "data"     => [
                    "id"      => 3,
                    "groupId" => 1,
                    "list"    => [1, 2, 9999],
                ],
                "hasError" => true,
            ],
            "userWithNoOperations" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "id"      => 4,
                    "groupId" => 0,
                    "list"    => [2, 3],
                ],
                "hasError" => true,
            ],
        ];
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
                "imageGroupId"      => 1,
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
                "url"     => "http://" . $this->getHost() . "/upload/1/new_file.jpg",
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
            "limitedIncorrectId"     => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => true,
                "id"       => 9999
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
     * Test for updateImage action
     *
     * @param string $user
     * @param string $file
     * @param array  $data
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateImage
     */
    public function testUpdateImage($user, $file, $data, $hasError = false)
    {
        // Create new one
        $this->setUser(self::TYPE_FULL);
        $this->sendFile("image", "image", $file, ["blockId" => $data["blockId"], "imageGroupId" => 1]);

        // Gets parameters of created
        $body = $this->getBody();
        $id = $body["id"];
        $originalFileName = explode("/", $body["originalUrl"]);
        $originalFileName = end($originalFileName);
        $viewFileName = explode("/", $body["viewUrl"]);
        $viewFileName = end($viewFileName);
        $thumbFileName = explode("/", $body["thumbUrl"]);
        $thumbFileName = end($thumbFileName);

        // Make sure that files exist
        $app = App::getInstance();
        $this->assertFileExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $originalFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $viewFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $thumbFileName
            )
        );

        // Update
        $this->setUser($user);
        $data["id"] = $id;
        $this->sendRequest("image", "image", $data, "PUT");

        if ($hasError === true) {
            $this->assertError();
            (new ImageInstanceModel())->byId($id)->find()->delete();
            return true;
        }

        // Compare
        $body = $this->getBody();
        $updatedOriginalFileName = explode("/", $body["originalUrl"]);
        $updatedOriginalFileName = end($updatedOriginalFileName);
        $updatedViewFileName = explode("/", $body["viewUrl"]);
        $updatedViewFileName = end($updatedViewFileName);
        $updatedThumbFileName = explode("/", $body["thumbUrl"]);
        $updatedThumbFileName = end($updatedThumbFileName);
        $this->assertSame($originalFileName, $updatedOriginalFileName);
        $this->assertNotSame($viewFileName, $updatedViewFileName);
        $this->assertNotSame($thumbFileName, $updatedThumbFileName);

        // Make sure new files exist
        $this->assertFileExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $updatedViewFileName
            )
        );
        $this->assertFileExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $updatedThumbFileName
            )
        );

        // Make sure old files don't exist
        $this->assertFileNotExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $viewFileName
            )
        );
        $this->assertFileNotExists(
            sprintf(
                $app->getConfig(["file", "pathMask"]),
                $app->getSite()->getId(),
                $thumbFileName
            )
        );

        // Check DB
        $imageInstanceModel = (new ImageInstanceModel())->byId($id)->find();
        $this->assertSame($data["isCover"], $imageInstanceModel->get("isCover"));
        $this->assertSame($data["alt"], $imageInstanceModel->get("alt"));
        $this->assertSame($data["x1"], $imageInstanceModel->get("x1"));
        $this->assertSame($data["y1"], $imageInstanceModel->get("y1"));
        $this->assertSame($data["x2"], $imageInstanceModel->get("x2"));
        $this->assertSame($data["y2"], $imageInstanceModel->get("y2"));
        $this->assertSame($data["thumbX1"], $imageInstanceModel->get("thumbX1"));
        $this->assertSame($data["thumbY1"], $imageInstanceModel->get("thumbY1"));
        $this->assertSame($data["thumbX2"], $imageInstanceModel->get("thumbX2"));
        $this->assertSame($data["thumbY2"], $imageInstanceModel->get("thumbY2"));
        $this->assertSame($data["angle"], $imageInstanceModel->get("angle"));
        $this->assertSame($data["flip"], $imageInstanceModel->get("flip"));
        $imageInstanceModel->delete();

        return true;
    }

    /**
     * Data provider for testUpdateImage
     *
     * @return array
     */
    public function dataProviderForTestUpdateImage()
    {
        return [
            "userJpgCorrect" => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.jpg",
                [
                    "blockId" => 3,
                    "isCover" => true,
                    "alt"     => "New alt",
                    "x1"      => 0,
                    "y1"      => 0,
                    "x2"      => 3000,
                    "y2"      => 1000,
                    "thumbX1" => 0,
                    "thumbY1" => 0,
                    "thumbX2" => 3000,
                    "thumbY2" => 1000,
                    "angle"   => 90,
                    "flip"    => 3,
                ],
                "hasError" => false
            ],
            "userPngCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "file"     => "bigImage.png",
                [
                    "blockId" => 3,
                    "isCover" => true,
                    "alt"     => "New alt",
                    "x1"      => 0,
                    "y1"      => 0,
                    "x2"      => 3000,
                    "y2"      => 1000,
                    "thumbX1" => 0,
                    "thumbY1" => 0,
                    "thumbX2" => 3000,
                    "thumbY2" => 1000,
                    "angle"   => 90,
                    "flip"    => 3,
                ],
                "hasError" => false
            ],
            "blockedJpg"              => [
                "user"     => self::TYPE_BLOCKED_USER,
                "file"     => "bigImage.jpg",
                [
                    "blockId" => 3,
                    "isCover" => true,
                    "alt"     => "New alt",
                    "x1"      => 0,
                    "y1"      => 0,
                    "x2"      => 3000,
                    "y2"      => 1000,
                    "thumbX1" => 0,
                    "thumbY1" => 0,
                    "thumbX2" => 3000,
                    "thumbY2" => 1000,
                    "angle"   => 90,
                    "flip"    => 3,
                ],
                "hasError" => true
            ],
        ];
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
                "imageGroupId"      => 1,
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
            "limitedIncorrectId"     => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => true,
                "id"       => 9999
            ],
            "limitedIncorrectFormat" => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => true,
                "id"       => "1"
            ],
            "limitedCorrect"              => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => false,
                "id"       => null
            ],
            "noOperation"              => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "hasError" => true,
                "id"       => null
            ],
        ];
    }

    /**
     * Test to get album
     *
     * @param string $user
     * @param int    $blockId
     * @param int    $id
     * @param bool   $hasError
     * @param bool   $hasErrors
     * @param string $title
     * @param string $name
     * @param string $buttonLabel
     *
     * @dataProvider dataProviderForTestGetAlbum
     *
     * @return bool
     */
    public function testGetAlbum(
        $user,
        $blockId,
        $id,
        $hasError,
        $hasErrors = false,
        $title = null,
        $name = null,
        $buttonLabel = null
    ) {
        $this->setUser($user);

        $this->sendRequest("image", "album", ["blockId" => $blockId, "id" => $id]);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        if ($hasErrors === true) {
            $this->assertErrors();
            return true;
        }

        $expected = [
            "blockId" => $blockId,
            "title"   => $title,
            "forms"   => [
                "name"   => [
                    "name"       => "name",
                    "label"      => "Name",
                    "validation" => ["required" => "required", "maxLength" => 255],
                    "value"      => $name,
                ],
                "button" => [
                    "label" => $buttonLabel,
                ]
            ]
        ];

        $this->compareExpectedAndActual($expected, $this->getBody());

        return true;
    }

    /**
     * Data provider for testGetAlbum
     *
     * @return array
     */
    public function dataProviderForTestGetAlbum()
    {
        return [
            "userUpdateCorrect" => [
                "user"      => self::TYPE_LIMITED,
                "blockId"   => 3,
                "id"        => 1,
                "hasError"  => false,
                "hasErrors" => false,
                "title"     => "Update album",
                "name"      => "Name",
                $buttonLabel = "Update"
            ],
            "userCreateCorrect" => [
                "user"      => self::TYPE_LIMITED,
                "blockId"   => 3,
                "id"        => 0,
                "hasError"  => false,
                "hasErrors" => false,
                "title"     => "Create album",
                "name"      => "",
                $buttonLabel = "Add"
            ],
            "userUpdateIncorrectId" => [
                "user"      => self::TYPE_LIMITED,
                "blockId"   => 3,
                "id"        => 999,
                "hasError"  => true,
            ],
            "userUpdateIncorrectBlockId" => [
                "user"      => self::TYPE_LIMITED,
                "blockId"   => 999,
                "id"        => 1,
                "hasError"  => true,
            ],
            "noOperationUpdate" => [
                "user"      => self::TYPE_NO_OPERATIONS_USER,
                "blockId"   => 3,
                "id"        => 1,
                "hasError"  => true,
            ],
            "noOperationCreate" => [
                "user"      => self::TYPE_NO_OPERATIONS_USER,
                "blockId"   => 3,
                "id"        => 0,
                "hasError"  => true,
            ],
        ];
    }

    /**
     * Test for the createAlbum method
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasError
     * @param bool   $hasErrors
     *
     * @dataProvider dataProviderForTestCreateAlbum
     */
    public function testCreateAlbum($user, $data, $hasError, $hasErrors)
    {
        $this->setUser($user);

        $this->sendRequest("image", "album", $data, "POST");

        if ($hasError === true) {
            $this->assertError();
        } elseif ($hasErrors === true) {
            $this->assertErrors();
        } else {
            $expected = [
                "result" => true
            ];
            $this->assertSame($expected, $this->getBody());
            (new ImageGroupModel())->latest()->find()->delete();
        }
    }

    /**
     * Data provider for testCreateAlbum
     *
     * @return array
     */
    public function dataProviderForTestCreateAlbum()
    {
        return [
            "limitedEmpty"       => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "blockId" => 3,
                    "name" => "",
                ],
                "hasError"  => false,
                "hasErrors" => true
            ],
            "limitedLongName"    => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "blockId" => 3,
                    "name" => $this->generateStringWithLength(256),
                ],
                "hasError"  => false,
                "hasErrors" => true
            ],
            "limitedCorrect"            => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "blockId" => 3,
                    "name" => "New album name",
                ],
                "hasError"  => false,
                "hasErrors" => false
            ],
            "limitedIncorrectBlockId"            => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "blockId" => 1,
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false
            ],
            "noOperation"              => [
                "user"      => self::TYPE_NO_OPERATIONS_USER,
                "data"      => [
                    "blockId" => 3,
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false
            ],
        ];
    }

    /**
     * Test for the updateAlbum method
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasError
     * @param bool   $hasErrors
     * @param int    $id
     *
     * @dataProvider dataProviderForTestUpdateAlbum
     */
    public function testUpdateAlbum($user, $data, $hasError = false, $hasErrors = false, $id = null)
    {
        $this->setUser($user);

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                "imageId" => 1,
                "name"    => $this->generateStringWithLength(10)
            ]
        );
        $imageGroupModel->save();

        if ($id === null) {
            $id = $imageGroupModel->getId();
        }

        $data = array_merge(
            $data,
            [
                "blockId" => 3,
                "id"      => $id
            ]
        );

        $this->sendRequest("image", "album", $data, "PUT");

        if ($hasError === true) {
            $this->assertError();
        } elseif ($hasErrors === true) {
            $this->assertErrors();
        } else {
            $expected = [
                "result" => true
            ];
            $this->assertSame($expected, $this->getBody());
        }

        $imageGroupModel->delete();
    }

    /**
     * Data provider for testUpdateAlbum
     *
     * @return array
     */
    public function dataProviderForTestUpdateAlbum()
    {
        return [
            "limitedIncorrectId" => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false,
                "id"        => 9999
            ],
            "limitedEmpty"       => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "name" => "",
                ],
                "hasError"  => false,
                "hasErrors" => true,
                "id"        => null
            ],
            "limitedLongName"    => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "name" => $this->generateStringWithLength(256),
                ],
                "hasError"  => false,
                "hasErrors" => true,
                "id"        => null
            ],
            "limitedCorrect"            => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => false,
                "hasErrors" => false,
                "id"        => null
            ],
            "noOperation"              => [
                "user"      => self::TYPE_NO_OPERATIONS_USER,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false,
                "id"        => null
            ],
        ];
    }

    /**
     * Test for method deleteAlbum
     *
     * @param string $user
     * @param bool   $hasError
     * @param int    $id
     *
     * @dataProvider dataProviderForTestDeleteAlbum
     */
    public function testDeleteAlbum($user, $hasError = false, $id = null)
    {
        $this->setUser($user);

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                "imageId" => 1,
                "name"    => $this->generateStringWithLength(10)
            ]
        );
        $imageGroupModel->save();

        if ($id === null) {
            $id = $imageGroupModel->getId();
        }

        $this->sendRequest("image", "album", ["blockId" => 3, "id" => $id], "DELETE");

        if ($hasError === true) {
            $this->assertError();
            $this->assertNotNull($imageGroupModel->byId($imageGroupModel->getId())->find());
            $imageGroupModel->delete();
        } else {
            $expected = [
                "result" => true
            ];
            $this->assertSame($expected, $this->getBody());
            $this->assertNull($imageGroupModel->byId($imageGroupModel->getId())->find());
        }
    }

    /**
     * Data provider for testDeleteAlbum
     *
     * @return array
     */
    public function dataProviderForTestDeleteAlbum()
    {
        return [
            "limitedIncorrectId" => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => true,
                "id"       => 9999
            ],
            "limited"            => [
                "user"     => self::TYPE_LIMITED,
                "hasError" => false,
                "id"       => null
            ],
            "noOperation"              => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "hasError" => true,
                "id"       => null
            ],
        ];
    }
}