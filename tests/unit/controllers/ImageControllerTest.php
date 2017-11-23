<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
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
     * Test for getBlocks
     *
     * @param string $user
     * @param int    $displayBlocksFromSection
     * @param bool   $hasError
     * @param bool   $hasResult
     * @param bool   $canAdd
     * @param bool   $canUpdateDesign
     * @param bool   $catUpdateContent
     * @param bool   $canUpdateSettings
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetBlocks
     */
    public function testGetBlocks(
        $user,
        $displayBlocksFromSection,
        $hasError,
        $hasResult = null,
        $canAdd = null,
        $canUpdateDesign = null,
        $catUpdateContent = null,
        $canUpdateSettings = null
    )
    {
        $this->setUser($user);
        $this->sendRequest("image", "blocks", ["displayBlocksFromSection" => $displayBlocksFromSection]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $this->assertTrue(strlen($body["title"]) > 0);
        $this->assertTrue(strlen($body["description"]) > 0);
        $this->assertSame("block", $body["back"]["controller"]);
        $this->assertSame("blocks", $body["back"]["action"]);
        $this->assertSame("image", $body["settings"]["controller"]);
        $this->assertSame("block", $body["settings"]["action"]);
        $this->assertSame("image", $body["design"]["controller"]);
        $this->assertSame("design", $body["design"]["action"]);
        $this->assertSame("image", $body["content"]["controller"]);
        $this->assertSame("content", $body["content"]["action"]);

        $this->assertSame($canAdd, $body["canAdd"]);

        if ($hasResult === false) {
            $this->assertSame(0, count($body["list"]));
            return true;
        } else {
            $this->assertTrue(count($body["list"]) > 0);
        }

        foreach ($body["list"] as $item) {
            $this->assertTrue(strlen($item["name"]) > 0);
            $this->assertTrue($item["id"] > 0);
            $this->assertSame($canUpdateSettings, $item["canUpdateSettings"]);
            $this->assertSame($canUpdateDesign, $item["canUpdateDesign"]);
            $this->assertSame($catUpdateContent, $item["canUpdateContent"]);
        }

        return true;
    }

    /**
     * Data provider for testGetBlocks
     *
     * @return array
     */
    public function dataProviderForTestGetBlocks()
    {
        return [
            "guestViewAll"                   => [
                "user"                     => null,
                "displayBlocksFromSection" => 0,
                "hasError"                 => true
            ],
            "guestViewFromPage"              => [
                "user"                     => null,
                "displayBlocksFromSection" => 1,
                "hasError"                 => true
            ],
            "guestViewFromNonexistentPage"   => [
                "user"                     => null,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => true
            ],
            "ownerViewAll"                   => [
                "user"                     => self::TYPE_OWNER,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "ownerViewFromPage"              => [
                "user"                     => self::TYPE_OWNER,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "ownerViewFromNonexistentPage"   => [
                "user"                     => self::TYPE_OWNER,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => true,
            ],
            "adminViewAll"                   => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "adminViewFromPage"              => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "adminViewFromNonexistentPage"   => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => true,
            ],
            "noOperationViewAll"             => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => false,
            ],
            "noOperationFromPage"            => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => false,
            ],
            "noOperationFromNonexistentPage" => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => false,
            ],
            "blockedViewAll"                 => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 0,
                "hasError"                 => true
            ],
            "blockedViewFromPage"            => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 1,
                "hasError"                 => true
            ],
            "blockedViewFromNonexistentPage" => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => true
            ],
            "limitedViewAll"                 => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "limitedViewFromPage"            => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
            ],
            "limitedViewFromNonexistentPage" => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 9999,
                "hasError"                 => false,
                "hasResult"                => false,
                "canAdd"                   => true,
            ],
        ];
    }

    /**
     * Test for getBlock method
     *
     * @param string $user
     * @param int    $id
     * @param  bool  $hasError
     * @param string $title
     * @param string $name
     * @param int    $type
     * @param int    $autoCropType
     * @param int    $cropWidth
     * @param int    $cropHeight
     * @param int    $cropX
     * @param int    $cropY
     * @param int    $thumbAutoCropType
     * @param int    $useAlbums
     * @param int    $thumbCropX
     * @param int    $thumbCropY
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetBlock
     */
    public function testGetBlock(
        $user,
        $id,
        $hasError,
        $title = null,
        $name = null,
        $type = null,
        $autoCropType = null,
        $cropWidth = null,
        $cropHeight = null,
        $cropX = null,
        $cropY = null,
        $thumbAutoCropType = null,
        $useAlbums = null,
        $thumbCropX = null,
        $thumbCropY = null
    )
    {
        $this->setUser($user);
        $this->sendRequest("image", "block", ["id" => $id]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $expected = [
            "id"    => $id,
            "title" => $title,
            "forms" => [
                "name"              => [
                    "name"       => "name",
                    "validation" => [],
                    "value"      => $name,
                ],
                "type"              => [
                    "value" => $type,
                    "name"  => "type",
                    "list"  => []
                ],
                "autoCropType"      => [
                    "value" => $autoCropType,
                    "name"  => "autoCropType",
                    "list"  => []
                ],
                "cropWidth"         => [
                    "name"  => "cropWidth",
                    "value" => $cropWidth,
                ],
                "cropHeight"        => [
                    "name"  => "cropHeight",
                    "value" => $cropHeight,
                ],
                "cropX"             => [
                    "name"  => "cropX",
                    "value" => $cropX,
                ],
                "cropY"             => [
                    "name"  => "cropY",
                    "value" => $cropY,
                ],
                "thumbAutoCropType" => [
                    "value" => $thumbAutoCropType,
                    "name"  => "thumbAutoCropType",
                    "list"  => []
                ],
                "useAlbums"         => [
                    "name"  => "useAlbums",
                    "value" => $useAlbums,
                ],
                "thumbCropX"        => [
                    "name"  => "thumbCropX",
                    "value" => $thumbCropX,
                ],
                "thumbCropY"        => [
                    "name"  => "thumbCropY",
                    "value" => $thumbCropY,
                ],
            ]
        ];

        $this->compareExpectedAndActual($expected, $body);

        return true;
    }

    /**
     * Data provider for testGetBlock
     *
     * @return array
     */
    public function dataProviderForTestGetBlock()
    {
        return [
            "adminAdd"            => [
                "user"              => self::TYPE_FULL,
                "id"                => 0,
                "hasError"          => false,
                "title"             => "Add image",
                "name"              => "",
                "type"              => 0,
                "autoCropType"      => 0,
                "cropWidth"         => 0,
                "cropHeight"        => 0,
                "cropX"             => 0,
                "cropY"             => 0,
                "thumbAutoCropType" => 0,
                "useAlbums"         => false,
                "thumbCropX"        => 0,
                "thumbCropY"        => 0,
            ],
            "adminEdit3"          => [
                "user"              => self::TYPE_FULL,
                "id"                => 3,
                "hasError"          => false,
                "title"             => "Edit image",
                "name"              => "Zoom image",
                "type"              => 2,
                "autoCropType"      => 0,
                "cropWidth"         => 0,
                "cropHeight"        => 0,
                "cropX"             => 0,
                "cropY"             => 0,
                "thumbAutoCropType" => 0,
                "useAlbums"         => false,
                "thumbCropX"        => 0,
                "thumbCropY"        => 0,
            ],
            "adminEdit4"          => [
                "user"              => self::TYPE_FULL,
                "id"                => 4,
                "hasError"          => false,
                "title"             => "Edit image",
                "name"              => "Slider image",
                "type"              => 1,
                "autoCropType"      => 5,
                "cropWidth"         => 1000,
                "cropHeight"        => 800,
                "cropX"             => 3,
                "cropY"             => 4,
                "thumbAutoCropType" => 8,
                "useAlbums"         => true,
                "thumbCropX"        => 1,
                "thumbCropY"        => 2,
            ],
            "adminEdit9999"       => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "hasError" => true
            ],
            "guestAdd"            => [
                "user"     => null,
                "id"       => 0,
                "hasError" => true
            ],
            "guestEdit3"          => [
                "user"     => null,
                "id"       => 3,
                "hasError" => true,
            ],
            "guestEdit4"          => [
                "user"     => null,
                "id"       => 4,
                "hasError" => true,
            ],
            "guestEdit9999"       => [
                "user"     => null,
                "id"       => 9999,
                "hasError" => true
            ],
            "blockedAdd"          => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "blockedEdit3"        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 3,
                "hasError" => true,
            ],
            "blockedEdit4"        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 4,
                "hasError" => true,
            ],
            "blockedEdit9999"     => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "noOperationAdd"      => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "noOperationEdit3"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 3,
                "hasError" => true,
            ],
            "noOperationEdit4"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 4,
                "hasError" => true,
            ],
            "noOperationEdit9999" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "userAdd"             => [
                "user"              => self::TYPE_LIMITED,
                "id"                => 0,
                "hasError"          => false,
                "title"             => "Add image",
                "name"              => "",
                "type"              => 0,
                "autoCropType"      => 0,
                "cropWidth"         => 0,
                "cropHeight"        => 0,
                "cropX"             => 0,
                "cropY"             => 0,
                "thumbAutoCropType" => 0,
                "useAlbums"         => false,
                "thumbCropX"        => 0,
                "thumbCropY"        => 0,
            ],
            "userEdit3"           => [
                "user"              => self::TYPE_LIMITED,
                "id"                => 3,
                "hasError"          => false,
                "title"             => "Edit image",
                "name"              => "Zoom image",
                "type"              => 2,
                "autoCropType"      => 0,
                "cropWidth"         => 0,
                "cropHeight"        => 0,
                "cropX"             => 0,
                "cropY"             => 0,
                "thumbAutoCropType" => 0,
                "useAlbums"         => false,
                "thumbCropX"        => 0,
                "thumbCropY"        => 0,
            ],
            "userEdit4"           => [
                "user"              => self::TYPE_LIMITED,
                "id"                => 4,
                "hasError"          => false,
                "title"             => "Edit image",
                "name"              => "Slider image",
                "type"              => 1,
                "autoCropType"      => 5,
                "cropWidth"         => 1000,
                "cropHeight"        => 800,
                "cropX"             => 3,
                "cropY"             => 4,
                "thumbAutoCropType" => 8,
                "useAlbums"         => true,
                "thumbCropX"        => 1,
                "thumbCropY"        => 2,
            ],
            "userEdit9999"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for createBlock method
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasError
     * @param bool   $hasValidationErrors
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestCreateBlock
     */
    public function testCreateBlock($user, $data, $hasError = false, $hasValidationErrors = false)
    {
        $imageModelCountBefore = (new ImageModel())->getCount();
        $blockModelCountBefore = (new BlockModel())->getCount();

        $this->setUser($user);
        $this->sendRequest("image", "block", $data, "POST");
        $body = $this->getBody();

        $imageModelCountAfter = (new ImageModel())->getCount();
        $blockModelCountAfter = (new BlockModel())->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame($imageModelCountBefore, $imageModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame($imageModelCountBefore, $imageModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            "result" => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockImageModel = (new BlockModel())->latest()->find();
        $imageModel = $blockImageModel->getContentModel();

        $this->assertSame($data["name"], $blockImageModel->get("name"));
        $this->assertSame($data["type"], $imageModel->get("type"));
        $this->assertSame($data["autoCropType"], $imageModel->get("autoCropType"));
        $this->assertSame($data["cropWidth"], $imageModel->get("cropWidth"));
        $this->assertSame($data["cropHeight"], $imageModel->get("cropHeight"));
        $this->assertSame($data["cropX"], $imageModel->get("cropX"));
        $this->assertSame($data["cropY"], $imageModel->get("cropY"));
        $this->assertSame($data["thumbAutoCropType"], $imageModel->get("thumbAutoCropType"));
        $this->assertSame($data["useAlbums"], $imageModel->get("useAlbums"));
        $this->assertSame($data["thumbCropX"], $imageModel->get("thumbCropX"));
        $this->assertSame($data["thumbCropY"], $imageModel->get("thumbCropY"));

        $this->assertSame($imageModelCountBefore, $imageModelCountAfter - 1);
        $this->assertSame($blockModelCountBefore, $blockModelCountAfter - 1);

        $blockImageModel->delete();

        return true;
    }

    /**
     * Data provider for testCreateBlock
     *
     * @return array
     */
    public function dataProviderForTestCreateBlock()
    {
        return [
            "fullCorrect"                    => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
            "fullEmptyName"                  => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"              => "",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => true,
            ],
            "guest"                          => [
                "user"     => null,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "blocked"                        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "noOperationUser"                => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "userWithoutType"                => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectType"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => "incorrect",
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutAutoCropType"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectAutoCropType"      => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => "incorrect",
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropWidth"           => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropWidth"         => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => "incorrect",
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropHeight"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropHeight"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => "incorrect",
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropX"               => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropX"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => "incorrect",
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropY"               => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropY"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => "incorrect",
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbAutoCropType"   => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"         => "Block name",
                    "type"         => 1,
                    "autoCropType" => 2,
                    "cropWidth"    => 100,
                    "cropHeight"   => 200,
                    "cropX"        => 300,
                    "cropY"        => 400,
                    "useAlbums"    => true,
                    "thumbCropX"   => 10,
                    "thumbCropY"   => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbAutoCropType" => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => "incorrect",
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutUseAlbums"           => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectUseAlbums"         => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => "incorrect",
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbCropX"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbCropX"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => "incorrect",
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbCropY"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbCropY"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => "incorrect",
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userCorrect"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
        ];
    }

    /**
     * Test for updateUser method
     *
     * @param string $user
     * @param array  $data
     * @param bool   $hasError
     * @param bool   $hasValidationErrors
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateBlock
     */
    public function testUpdateBlock($user, $data, $hasError = false, $hasValidationErrors = false)
    {
        $imageModel = new ImageModel();
        $imageModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => "name",
                "language"    => 1,
                "contentType" => BlockModel::TYPE_IMAGE,
                "contentId"   => $imageModel->getId(),
            ]
        );
        $blockModel->save();

        $data["id"] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest("image", "block", $data, "PUT");
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();
            $blockModel->delete();
            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();
            $blockModel->delete();
            return true;
        }

        $this->assertArrayHasKey("html", $body);
        $this->assertArrayHasKey("css", $body);
        $this->assertArrayHasKey("js", $body);
        $this->assertTrue($body["result"]);

        $imageModel = (new ImageModel())->byId($imageModel->getId())->find();
        $blockModel = BlockModel::getById($blockModel->getId());

        $this->assertSame($data["name"], $blockModel->get("name"));
        $this->assertSame($data["type"], $imageModel->get("type"));
        $this->assertSame($data["autoCropType"], $imageModel->get("autoCropType"));
        $this->assertSame($data["cropWidth"], $imageModel->get("cropWidth"));
        $this->assertSame($data["cropHeight"], $imageModel->get("cropHeight"));
        $this->assertSame($data["cropX"], $imageModel->get("cropX"));
        $this->assertSame($data["cropY"], $imageModel->get("cropY"));
        $this->assertSame($data["thumbAutoCropType"], $imageModel->get("thumbAutoCropType"));
        $this->assertSame($data["useAlbums"], $imageModel->get("useAlbums"));
        $this->assertSame($data["thumbCropX"], $imageModel->get("thumbCropX"));
        $this->assertSame($data["thumbCropY"], $imageModel->get("thumbCropY"));

        $blockModel->delete();

        return true;
    }

    /**
     * Data provider for testUpdateBlock
     *
     * @return array
     */
    public function dataProviderForTestUpdateBlock()
    {
        return [
            "fullCorrect"                    => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
            "fullEmptyName"                  => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"              => "",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => true,
            ],
            "guest"                          => [
                "user"     => null,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "blocked"                        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "noOperationUser"                => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError" => true,
            ],
            "userWithoutType"                => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectType"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => "incorrect",
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutAutoCropType"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectAutoCropType"      => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => "incorrect",
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropWidth"           => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropWidth"         => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => "incorrect",
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropHeight"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropHeight"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => "incorrect",
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropX"               => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropX"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => "incorrect",
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutCropY"               => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectCropY"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => "incorrect",
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbAutoCropType"   => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"         => "Block name",
                    "type"         => 1,
                    "autoCropType" => 2,
                    "cropWidth"    => 100,
                    "cropHeight"   => 200,
                    "cropX"        => 300,
                    "cropY"        => 400,
                    "useAlbums"    => true,
                    "thumbCropX"   => 10,
                    "thumbCropY"   => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbAutoCropType" => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => "incorrect",
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutUseAlbums"           => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectUseAlbums"         => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => "incorrect",
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbCropX"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbCropX"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => "incorrect",
                    "thumbCropY"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutThumbCropY"          => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 20,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectThumbCropY"        => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => "incorrect",
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userCorrect"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "type"              => 1,
                    "autoCropType"      => 2,
                    "cropWidth"         => 100,
                    "cropHeight"        => 200,
                    "cropX"             => 300,
                    "cropY"             => 400,
                    "thumbAutoCropType" => 3,
                    "useAlbums"         => true,
                    "thumbCropX"        => 10,
                    "thumbCropY"        => 20,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
        ];
    }

    /**
     * Test for the method deleteBlock
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestDeleteBlock
     */
    public function testDeleteBlock($user, $id = null, $hasError = false)
    {
        $this->setUser($user);

        $blockModel = null;
        if ($id === null) {
            $imageModel = new ImageModel();
            $imageModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    "name"        => "name",
                    "language"    => 1,
                    "contentType" => BlockModel::TYPE_IMAGE,
                    "contentId"   => $imageModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        } else {
            $requestId = $id;
        }

        $this->sendRequest("image", "block", ["id" => $requestId], "DELETE");

        if ($hasError === true) {
            $this->assertError();

            if ($id === null) {
                $blockModel->delete();
            }
        } else {
            $expected = [
                "result" => true
            ];

            $this->compareExpectedAndActual($expected, $this->getBody());

            $this->assertNull((new BlockModel())->byId($blockModel->getId())->find());
        }
    }

    /**
     * Data provider for testDeleteBlock
     *
     * @return array
     */
    public function dataProviderForTestDeleteBlock()
    {
        return [
            "fullCorrect"            => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "hasError" => false
            ],
            "fullIncorrect"          => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "hasError" => true
            ],
            "fullIncorrectTypeBlock" => [
                "user"     => self::TYPE_FULL,
                "id"       => 1,
                "hasError" => true
            ],
            "userCorrect"            => [
                "user"     => self::TYPE_LIMITED,
                "id"       => null,
                "hasError" => false
            ],
            "userIncorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "blockedCorrect"         => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => null,
                "hasError" => true
            ],
            "blockedIncorrect"       => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "noOperationCorrect"     => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => null,
                "hasError" => true
            ],
            "noOperationIncorrect"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "guestCorrect"           => [
                "user"     => null,
                "id"       => null,
                "hasError" => true
            ],
            "guestIncorrect"         => [
                "user"     => null,
                "id"       => 9999,
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for the method createBlockDuplication
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     *
     * @dataProvider dataProviderForTestCreateBlockDuplication
     */
    public function testCreateBlockDuplication($user, $id = null, $hasError = false)
    {
        $this->setUser($user);

        $this->sendRequest("image", "blockDuplication", ["id" => $id], "POST");

        if ($hasError === true) {
            $this->assertError();
        } else {
            $body = $this->getBody();
            $this->assertTrue($body["id"] > $id);

            $blockModel = (new BlockModel())->latest()->find();

            $imageModel = $blockModel->getContentModel();
            $this->assertTrue($imageModel instanceof ImageModel);

            $blockModel->delete();
        }
    }

    /**
     * Data provider for testCreateBlockDuplication
     *
     * @return array
     */
    public function dataProviderForTestCreateBlockDuplication()
    {
        return [
            "fullCorrect"          => [
                "user"     => self::TYPE_FULL,
                "id"       => 3,
                "hasError" => false,
            ],
            "fullIncorrect"        => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "hasError" => true
            ],
            "userCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 3,
                "hasError" => false,
            ],
            "userIncorrect"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "blockedCorrect"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 3,
                "hasError" => true
            ],
            "blockedIncorrect"     => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "noOperationCorrect"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 3,
                "hasError" => true
            ],
            "noOperationIncorrect" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "guestCorrect"         => [
                "user"     => null,
                "id"       => 3,
                "hasError" => true
            ],
            "guestIncorrect"       => [
                "user"     => null,
                "id"       => 9999,
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for method getDesign
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     * @param array  $expected
     *
     * @dataProvider dataProviderForTestGetDesign
     *
     * @return bool
     */
    public function testGetDesign($user, $id, $hasError, $expected)
    {
        $this->setUser($user);

        $this->sendRequest("image", "design", ["id" => $id]);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody());

        return true;
    }

    /**
     * Data provider for testGetDesign
     *
     * @return array
     */
    public function dataProviderForTestGetDesign()
    {
        return [
            "userSimple" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 3,
                "hasError" => false,
                "expected" => [
                    "id" => 3,
                    "controller" => "image",
                    "action" => "design",
                    "list" => [
                        [
                            "title" => "Image design",
                            "data" => [
                                [
                                    "selector" => ".block-3",
                                    "id" => "block-3-block",
                                    "type" => "block",
                                    "namespace" => "designBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-1",
                                    "id" => "image-1-block",
                                    "type" => "block",
                                    "namespace" => "designImageSimpleModel.containerDesignBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-1 .image-instance",
                                    "id" => "image-1-image-instance-block",
                                    "type" => "block",
                                    "namespace" => "designImageSimpleModel.imageDesignBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-1",
                                    "id" => "image-1-image-simple",
                                    "type" => "image-simple",
                                    "namespace" => "designImageSimpleModel",
                                    "values" => [
                                        "alignment" => 0
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "button" => [
                        "label" => "Save"
                    ]
                ]
            ],
            "userSlider" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 4,
                "hasError" => false,
                "expected" => [
                    "id" => 4,
                    "controller" => "image",
                    "action" => "design",
                    "list" => [
                        [
                            "title" => "Image design",
                            "data" => [
                                [
                                    "selector" => ".block-4",
                                    "id" => "block-4-block",
                                    "type" => "block",
                                    "namespace" => "designBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-2",
                                    "id" => "image-2-block",
                                    "type" => "block",
                                    "namespace" => "designImageSliderModel.containerDesignBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-2 .navigation",
                                    "id" => "image-2-navigation-block",
                                    "type" => "block",
                                    "namespace" => "designImageSliderModel.navigationDesignBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-2 .description",
                                    "id" => "image-2-description-block",
                                    "type" => "block",
                                    "namespace" => "designImageSliderModel.descriptionDesignBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-2",
                                    "id" => "image-2-image-slider",
                                    "type" => "image-slider",
                                    "namespace" => "designImageSliderModel",
                                    "values" => [
                                        "effect"               => 0,
                                        "hasAutoPlay"          => false,
                                        "playSpeed"            => 0,
                                        "navigationAlignment"  => 0,
                                        "descriptionAlignment" => 0,
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "button" => [
                        "label" => "Save"
                    ]
                ]
            ],
            "userZoom" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 5,
                "hasError" => false,
                "expected" => [
                    "id" => 5,
                    "controller" => "image",
                    "action" => "design",
                    "list" => [
                        [
                            "title" => "Image design",
                            "data" => [
                                [
                                    "selector" => ".block-5",
                                    "id" => "block-5-block",
                                    "type" => "block",
                                    "namespace" => "designBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-3",
                                    "id" => "image-3-block",
                                    "type" => "block",
                                    "namespace" => "designImageZoomModel.designBlockModel",
                                    "values" => [
                                        "marginTop" => 0
                                    ]
                                ],
                                [
                                    "selector" => ".image-3",
                                    "id" => "image-3-image-zoom",
                                    "type" => "image-zoom",
                                    "namespace" => "designImageZoomModel",
                                    "values" => [
                                        "hasScroll"            => false,
                                        "thumbsAlignment"      => 0,
                                        "descriptionAlignment" => 0,
                                        "effect"               => 0,
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "button" => [
                        "label" => "Save"
                    ]
                ]
            ],
            "noOperationSimple" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 3,
                "hasError" => true,
                "expected" => []
            ]
        ];
    }

    public function testUpdateDesign()
    {
        $this->markTestSkipped();
    }

    /**
     * Test for method getContent
     *
     * @param string $user
     * @param int    $blockId
     * @param bool   $hasError
     * @param array  $expected
     * @param int    $groupId
     *
     * @dataProvider dataProviderForTestGetContent
     *
     * @return bool
     */
    public function testGetContent($user, $blockId, $hasError, $expected, $groupId = null)
    {
        $this->setUser($user);

        $data = [
            "id" => $blockId
        ];
        if ($groupId !== null) {
            $data["groupId"] = $groupId;
        }

        $this->sendRequest("image", "content", $data);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody());

        return true;
    }

    /**
     * Data provider for testGetContent
     *
     * @return array
     */
    public function dataProviderForTestGetContent()
    {
        return [
            "userCorrectAlbums" => [
                "user"     => self::TYPE_LIMITED,
                "blockId"  => 5,
                "hasError" => false,
                "expected" => [
                    "labels"         => [],
                    "useAlbums"      => true,
                    "canCreateAlbum" => true,
                    "canUpdateAlbum" => true,
                    "canDeleteAlbum" => true,
                    "list"           => [
                        [
                            "id"    => 4,
                            "name"  => "Name 1",
                            "cover" => []
                        ],
                        [
                            "id"    => 5,
                            "name"  => "Name 2",
                            "cover" => null
                        ]
                    ]
                ]
            ],
            "userCorrectAlbum" => [
                "user"     => self::TYPE_LIMITED,
                "blockId"  => 5,
                "hasError" => false,
                "expected" => [
                    "labels"         => [],
                    "useAlbums"      => false,
                    "canUploadImage" => true,
                    "canUpdateImage" => true,
                    "canDeleteImage" => true,
                    "list"           => [
                        [
                            "id"  => 3,
                            "alt" => "",
                        ],
                        [
                            "id"  => 4,
                            "alt" => "",
                        ]
                    ]
                ],
                "groupId"  => 4,
            ],
            "userCorrectWithoutAlbums" => [
                "user" => self::TYPE_LIMITED,
                "blockId"  => 3,
                "hasError" => false,
                "expected" => []
            ],
            "userIncorrectBlock" => [
                "user"     => self::TYPE_LIMITED,
                "blockId"  => 1,
                "hasError" => true,
                "expected" => [
                    "labels"         => [],
                    "useAlbums"      => false,
                    "canUploadImage" => true,
                    "canUpdateImage" => true,
                    "canDeleteImage" => true,
                    "list"           => [
                        [
                            "id"  => 1,
                            "alt" => "",
                        ],
                        [
                            "id"  => 2,
                            "alt" => "",
                        ]
                    ]
                ]
            ],
            "withoutOperations"  => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "blockId"  => 5,
                "hasError" => true,
                "expected" => []
            ]
        ];
    }

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
        $this->sendFile("image", "image", $file, ["blockId" => $blockId, "imageGroupId" => $albumId]);

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
        $this->markTestSkipped("Delete files");

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
            "admin"              => [
                "user"      => self::TYPE_FULL,
                "data"      => [
                    "blockId" => 3,
                    "name" => "New album name",
                ],
                "hasError"  => false,
                "hasErrors" => false
            ],
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
            "limited"            => [
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
            "guest"              => [
                "user"      => null,
                "data"      => [
                    "blockId" => 3,
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false
            ],
            "blocked"            => [
                "user"      => self::TYPE_BLOCKED_USER,
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
            "admin"              => [
                "user"      => self::TYPE_FULL,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => false,
                "hasErrors" => false,
                "id"        => null
            ],
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
            "limited"            => [
                "user"      => self::TYPE_LIMITED,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => false,
                "hasErrors" => false,
                "id"        => null
            ],
            "guest"              => [
                "user"      => null,
                "data"      => [
                    "name" => "New album name",
                ],
                "hasError"  => true,
                "hasErrors" => false,
                "id"        => null
            ],
            "blocked"            => [
                "user"      => self::TYPE_BLOCKED_USER,
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
            "admin"              => [
                "user"     => self::TYPE_FULL,
                "hasError" => false,
                "id"       => null
            ],
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
            "guest"              => [
                "user"     => null,
                "hasError" => true,
                "id"       => null
            ],
            "blocked"            => [
                "user"     => self::TYPE_BLOCKED_USER,
                "hasError" => true,
                "id"       => null
            ],
        ];
    }
}