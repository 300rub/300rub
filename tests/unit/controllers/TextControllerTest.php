<?php

namespace testS\tests\unit\controllers;

use testS\models\BlockModel;
use testS\models\DesignBlockModel;
use testS\models\DesignTextModel;
use testS\models\TextInstanceModel;
use testS\models\TextModel;

/**
 * Tests for the controller TextController
 *
 * @package testS\tests\unit\controllers
 */
class TextControllerTest extends AbstractControllerTest
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
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => $displayBlocksFromSection]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $this->assertTrue(strlen($body["title"]) > 0);
        $this->assertTrue(strlen($body["description"]) > 0);
        $this->assertSame("block", $body["back"]["controller"]);
        $this->assertSame("blocks", $body["back"]["action"]);
        $this->assertSame("text", $body["settings"]["controller"]);
        $this->assertSame("block", $body["settings"]["action"]);
        $this->assertSame("text", $body["design"]["controller"]);
        $this->assertSame("design", $body["design"]["action"]);
        $this->assertSame("text", $body["content"]["controller"]);
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
     * @param bool   $hasEditor
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetBlock
     */
    public function testGetBlock($user, $id, $hasError, $title = null, $name = null, $type = null, $hasEditor = null)
    {
        $this->setUser($user);
        $this->sendRequest("text", "block", ["id" => $id]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $expected = [
            "id"    => $id,
            "title" => $title,
            "forms" => [
                "name"      => [
                    "name"       => "name",
                    "label"      => "Name",
                    "validation" => [],
                    "value"      => $name,
                ],
                "type"      => [
                    "label" => "Type",
                    "value" => $type,
                    "name"  => "type",
                    "list"  => []
                ],
                "hasEditor" => [
                    "name"  => "hasEditor",
                    "label" => "Has editor",
                    "value" => $hasEditor,
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
            "ownerAdd"            => [
                "user"      => self::TYPE_OWNER,
                "id"        => 0,
                "hasError"  => false,
                "title"     => "Add text",
                "name"      => "",
                "type"      => 0,
                "hasEditor" => false
            ],
            "ownerEdit1"          => [
                "user"      => self::TYPE_OWNER,
                "id"        => 1,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Simple text",
                "type"      => 0,
                "hasEditor" => false
            ],
            "ownerEdit2"          => [
                "user"      => self::TYPE_OWNER,
                "id"        => 2,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Text with editor",
                "type"      => 0,
                "hasEditor" => true
            ],
            "ownerEdit9999"       => [
                "user"     => self::TYPE_OWNER,
                "id"       => 9999,
                "hasError" => true
            ],
            "adminAdd"            => [
                "user"      => self::TYPE_FULL,
                "id"        => 0,
                "hasError"  => false,
                "title"     => "Add text",
                "name"      => "",
                "type"      => 0,
                "hasEditor" => false
            ],
            "adminEdit1"          => [
                "user"      => self::TYPE_FULL,
                "id"        => 1,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Simple text",
                "type"      => 0,
                "hasEditor" => false
            ],
            "adminEdit2"          => [
                "user"      => self::TYPE_FULL,
                "id"        => 2,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Text with editor",
                "type"      => 0,
                "hasEditor" => true
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
            "guestEdit1"          => [
                "user"     => null,
                "id"       => 1,
                "hasError" => true,
            ],
            "guestEdit2"          => [
                "user"     => null,
                "id"       => 2,
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
            "blockedEdit1"        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 1,
                "hasError" => true,
            ],
            "blockedEdit2"        => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 2,
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
            "noOperationEdit1"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 1,
                "hasError" => true,
            ],
            "noOperationEdit2"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 2,
                "hasError" => true,
            ],
            "noOperationEdit9999" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "userAdd"             => [
                "user"      => self::TYPE_LIMITED,
                "id"        => 0,
                "hasError"  => false,
                "title"     => "Add text",
                "name"      => "",
                "type"      => 0,
                "hasEditor" => false
            ],
            "userEdit1"           => [
                "user"      => self::TYPE_LIMITED,
                "id"        => 1,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Simple text",
                "type"      => 0,
                "hasEditor" => false
            ],
            "userEdit2"           => [
                "user"      => self::TYPE_LIMITED,
                "id"        => 2,
                "hasError"  => false,
                "title"     => "Edit text",
                "name"      => "Text with editor",
                "type"      => 0,
                "hasEditor" => true
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
        $textModelCountBefore = (new TextModel())->getCount();
        $textInstanceModelCountBefore = (new TextInstanceModel())->getCount();
        $blockModelCountBefore = (new BlockModel())->getCount();

        $this->setUser($user);
        $this->sendRequest("text", "block", $data, "POST");
        $body = $this->getBody();

        $textModelCountAfter = (new TextModel())->getCount();
        $textInstanceModelCountAfter = (new TextInstanceModel())->getCount();
        $blockModelCountAfter = (new BlockModel())->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame($textModelCountBefore, $textModelCountAfter);
            $this->assertSame($textInstanceModelCountBefore, $textInstanceModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame($textModelCountBefore, $textModelCountAfter);
            $this->assertSame($textInstanceModelCountBefore, $textInstanceModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            "result" => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockTextModel = (new BlockModel())->latest()->find();
        $textModel = $blockTextModel->getContentModel();
        $this->assertSame($data["name"], $blockTextModel->get("name"));
        $this->assertSame($data["type"], $textModel->get("type"));
        $this->assertSame($data["hasEditor"], $textModel->get("hasEditor"));

        $this->assertSame($textModelCountBefore, $textModelCountAfter - 1);
        $this->assertSame($textInstanceModelCountBefore, $textInstanceModelCountAfter - 1);
        $this->assertSame($blockModelCountBefore, $blockModelCountAfter - 1);

        $blockTextModel->delete();

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
            "fullCorrect"             => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
            "fullEmptyName"           => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"      => "",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError"            => false,
                "hasValidationErrors" => true,
            ],
            "fullIncorrectHasEditor"  => [
                "user"     => self::TYPE_FULL,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 1,
                    "hasEditor" => 999,
                ],
                "hasError" => true,
            ],
            "fullIncorrectParameters" => [
                "user"     => self::TYPE_FULL,
                "data"     => [
                    "name" => "Block name",
                ],
                "hasError" => true,
            ],
            "guest"                   => [
                "user"     => null,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "blocked"                 => [
                "user"     => self::TYPE_BLOCKED_USER,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "noOperationUser"         => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "userCorrect"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
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
        $textModel = new TextModel();
        $textModel->set(
            [
                "type"      => 0,
                "hasEditor" => 0,
            ]
        );
        $textModel->save();

        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel->set(
            [
                "textId" => $textModel->getId(),
                "text"   => "test text",
            ]
        );
        $textInstanceModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => "name",
                "language"    => 1,
                "contentType" => BlockModel::TYPE_TEXT,
                "contentId"   => $textModel->getId(),
            ]
        );
        $blockModel->save();

        $data["id"] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest("text", "block", $data, "PUT");
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
        $this->assertNotFalse(strpos($body["html"], "test text"));

        $textModel = (new TextModel())->byId($textModel->getId())->find();
        $blockModel = BlockModel::getById($blockModel->getId());

        $this->assertSame($data["name"], $blockModel->get("name"));
        $this->assertSame($data["type"], $textModel->get("type"));
        $this->assertSame($data["hasEditor"], $textModel->get("hasEditor"));

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
            "fullCorrect"             => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => true,
                ],
                "hasError"            => false,
                "hasValidationErrors" => false,
            ],
            "fullEmptyName"           => [
                "user"                => self::TYPE_FULL,
                "data"                => [
                    "name"      => "",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError"            => false,
                "hasValidationErrors" => true,
            ],
            "fullIncorrectHasEditor"  => [
                "user"     => self::TYPE_FULL,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 1,
                    "hasEditor" => 999,
                ],
                "hasError" => true,
            ],
            "fullIncorrectParameters" => [
                "user"     => self::TYPE_FULL,
                "data"     => [
                    "name" => "Block name",
                ],
                "hasError" => true,
            ],
            "guest"                   => [
                "user"     => null,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "blocked"                 => [
                "user"     => self::TYPE_BLOCKED_USER,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "noOperationUser"         => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
                ],
                "hasError" => true,
            ],
            "userCorrect"             => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"      => "Block name",
                    "type"      => 0,
                    "hasEditor" => false,
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
            $textModel = new TextModel();
            $textModel->set(
                [
                    "type"      => 0,
                    "hasEditor" => 0,
                ]
            );
            $textModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    "name"        => "name",
                    "language"    => 1,
                    "contentType" => BlockModel::TYPE_TEXT,
                    "contentId"   => $textModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        } else {
            $requestId = $id;
        }

        $this->sendRequest("text", "block", ["id" => $requestId], "DELETE");

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
            "fullCorrect"          => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "hasError" => false
            ],
            "fullIncorrect"        => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "hasError" => true
            ],
            "userCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => null,
                "hasError" => false
            ],
            "userIncorrect"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "blockedCorrect"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => null,
                "hasError" => true
            ],
            "blockedIncorrect"     => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "noOperationCorrect"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => null,
                "hasError" => true
            ],
            "noOperationIncorrect" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "guestCorrect"         => [
                "user"     => null,
                "id"       => null,
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

        $this->sendRequest("text", "blockDuplication", ["id" => $id], "POST");

        if ($hasError === true) {
            $this->assertError();
        } else {
            $body = $this->getBody();
            $this->assertTrue($body["id"] > $id);

            $blockModel = (new BlockModel())->latest()->find();

            $textModel = $blockModel->getContentModel();
            $this->assertTrue($textModel instanceof TextModel);

            $textInstanceModel = (new TextInstanceModel())->byTextId($textModel->getId())->find();
            $this->assertTrue($textInstanceModel instanceof TextInstanceModel);

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
                "id"       => 1,
                "hasError" => false,
            ],
            "fullIncorrect"        => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "hasError" => true
            ],
            "userCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 1,
                "hasError" => false,
            ],
            "userIncorrect"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "blockedCorrect"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "blockedIncorrect"     => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 9999,
                "hasError" => true
            ],
            "noOperationCorrect"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "noOperationIncorrect" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 9999,
                "hasError" => true
            ],
            "guestCorrect"         => [
                "user"     => null,
                "id"       => 1,
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
     * Test for get design method
     *
     * @param string $user
     * @param int    $id
     * @param  bool  $hasError
     * @param array  $expectedBlockData
     * @param array  $expectedTextData
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetDesign
     */
    public function testGetDesign($user, $id, $hasError, $expectedBlockData = [], $expectedTextData = [])
    {
        $this->setUser($user);
        $this->sendRequest("text", "design", ["id" => $id]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $expected = [
            "id"          => $id,
            "controller"  => "text",
            "action"      => "design",
            "title"       => "Text design",
            "description" => "You can configure text's design",
            "list"        => [
                [
                    "title" => "Text design",
                    "data"  => [
                        [
                            "selector"  => sprintf(".block-%s", $id),
                            "id"        => sprintf("block-%s-block", $id),
                            "type"      => "block",
                            "title"     => "Block design",
                            "namespace" => "designBlockModel",
                            "labels"    => [
                                "margin" => "Margin",
                            ],
                            "values"    => $expectedBlockData,
                        ],
                        [
                            "selector"  => sprintf(".block-%s", $id),
                            "id"        => sprintf("block-%s-text", $id),
                            "type"      => "text",
                            "title"     => "Text design",
                            "namespace" => "designTextModel",
                            "labels"    => [
                                "mouseHoverEffect" => "Mouse-over effect",
                            ],
                            "values"    => $expectedTextData
                        ]
                    ]
                ]
            ],
            "button"     => [
                "label" => "Save",
            ],
        ];

        $this->compareExpectedAndActual($expected, $body);

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
            "admin1"         => [
                "user"              => self::TYPE_FULL,
                "id"                => 1,
                "hasError"          => false,
                "expectedBlockData" => [
                    "marginTop" => 0
                ],
                "expectedTextData"  => [
                    "size" => 14
                ],
            ],
            "admin0"         => [
                "user"     => self::TYPE_FULL,
                "id"       => 0,
                "hasError" => true
            ],
            "admin999"       => [
                "user"     => self::TYPE_FULL,
                "id"       => 999,
                "hasError" => true
            ],
            "user1"          => [
                "user"              => self::TYPE_LIMITED,
                "id"                => 1,
                "hasError"          => false,
                "expectedBlockData" => [
                    "marginBottom" => 0
                ],
                "expectedTextData"  => [
                    "family" => 0
                ],
            ],
            "user0"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 0,
                "hasError" => true
            ],
            "user999"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 999,
                "hasError" => true
            ],
            "blocked1"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "blocked0"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "blocked999"     => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 999,
                "hasError" => true
            ],
            "noOperation1"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "noOperation0"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "noOperation999" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 999,
                "hasError" => true
            ],
            "guest1"         => [
                "user"     => null,
                "id"       => 1,
                "hasError" => true
            ],
            "guest0"         => [
                "user"     => null,
                "id"       => 0,
                "hasError" => true
            ],
            "guest999"       => [
                "user"     => null,
                "id"       => 999,
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for method updateDesign
     *
     * @param string $user
     * @param int    $id
     * @param array  $data
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateDesign
     */
    public function testUpdateDesign($user, $id, $data, $hasError)
    {
        $blockModel = null;
        if ($id === null) {
            $textModel = new TextModel();
            $textModel->set(
                [
                    "type"      => 0,
                    "hasEditor" => 0,
                ]
            );
            $textModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    "name"        => "name",
                    "language"    => 1,
                    "contentType" => BlockModel::TYPE_TEXT,
                    "contentId"   => $textModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        } else {
            $requestId = $id;
        }

        $this->setUser($user);
        $this->sendRequest("text", "design", array_merge($data, ["id" => $requestId]), "PUT");
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();

            if ($id === null) {
                $blockModel->delete();
            }
            return true;
        }

        $this->assertTrue($body["result"]);

        $designBlockModel = (new DesignBlockModel())->latest()->find();
        $this->compareExpectedAndActual($data["designBlockModel"], $designBlockModel->get());

        $designTextModel = (new DesignTextModel())->latest()->find();
        $this->compareExpectedAndActual($data["designTextModel"], $designTextModel->get());

        $blockModel->delete();
        return true;
    }

    /**
     * Data provider for testUpdateDesign
     *
     * @return array
     */
    public function dataProviderForTestUpdateDesign()
    {
        return [
            "adminCorrect" => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => false
            ],
            "adminIncorrectId" => [
                "user"     => self::TYPE_FULL,
                "id"       => 9999,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => true
            ],
            "adminIncorrectData" => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                ],
                "hasError" => true
            ],
            "userCorrect" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => false
            ],
            "noOperationsCorrect" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => true
            ],
            "blockedCorrect" => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => true
            ],
            "guestCorrect" => [
                "user"     => null,
                "id"       => null,
                "data"     => [
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "designTextModel"  => [
                        "size" => 20
                    ]
                ],
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for the method getContent
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     * @param string $name
     * @param int    $type
     * @param bool   $hasEditor
     * @param string $value
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetContent
     */
    public function testGetContent($user, $id, $hasError, $name = null, $type = null, $hasEditor = null, $value = null)
    {
        $this->setUser($user);
        $this->sendRequest("text", "content", ["id" => $id]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $expected = [
            "id"        => $id,
            "name"      => $name,
            "type"      => $type,
            "hasEditor" => $hasEditor,
            "text"      => [
                "name"  => "text",
                "label" => "Text",
                "value" => $value,
            ],
            "button"    => [
                "label" => "Update",
            ]
        ];

        $this->compareExpectedAndActual($expected, $body);

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
            "admin1"         => [
                "user"      => self::TYPE_FULL,
                "id"        => 1,
                "hasError"  => false,
                "name"      => "Simple text",
                "type"      => 0,
                "hasEditor" => false,
                "value"     => "Text"
            ],
            "admin0"         => [
                "user"     => self::TYPE_FULL,
                "id"       => 0,
                "hasError" => true
            ],
            "admin999"       => [
                "user"     => self::TYPE_FULL,
                "id"       => 999,
                "hasError" => true
            ],
            "user1"          => [
                "user"      => self::TYPE_LIMITED,
                "id"        => 1,
                "hasError"  => false,
                "name"      => "Simple text",
                "type"      => 0,
                "hasEditor" => false,
                "value"     => "Text"
            ],
            "user0"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 0,
                "hasError" => true
            ],
            "user999"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 999,
                "hasError" => true
            ],
            "blocked1"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "blocked0"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "blocked999"     => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 999,
                "hasError" => true
            ],
            "noOperation1"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 1,
                "hasError" => true
            ],
            "noOperation0"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "noOperation999" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 999,
                "hasError" => true
            ],
            "guest1"         => [
                "user"     => null,
                "id"       => 1,
                "hasError" => true
            ],
            "guest0"         => [
                "user"     => null,
                "id"       => 0,
                "hasError" => true
            ],
            "guest999"       => [
                "user"     => null,
                "id"       => 999,
                "hasError" => true
            ],
        ];
    }

    /**
     * Test for the method updateContent
     *
     * @param string $user
     * @param int    $id
     * @param string $text
     * @param bool   $hasError
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestUpdateContent
     */
    public function testUpdateContent($user, $id, $text, $hasError)
    {
        $blockModel = null;
        if ($id === null) {
            $textModel = new TextModel();
            $textModel->set(
                [
                    "type"      => 0,
                    "hasEditor" => 0,
                ]
            );
            $textModel->save();

            $textInstanceModel = new TextInstanceModel();
            $textInstanceModel->set(
                [
                    "textId" => $textModel->getId(),
                    "text"   => "",
                ]
            );
            $textInstanceModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    "name"        => "name",
                    "language"    => 1,
                    "contentType" => BlockModel::TYPE_TEXT,
                    "contentId"   => $textModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        } else {
            $requestId = $id;
        }

        $data = [
            "id"   => $requestId,
            "text" => $text,
        ];

        $this->setUser($user);
        $this->sendRequest("text", "content", $data, "PUT");
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();

            if ($id === null) {
                $blockModel->delete();
            }
            return true;
        }

        $this->assertArrayHasKey("html", $body);
        $this->assertArrayHasKey("css", $body);
        $this->assertArrayHasKey("js", $body);
        $this->assertTrue($body["result"]);

        if ($text) {
            $this->assertNotFalse(strpos($body["html"], $text));
        }

        $blockModel->delete();
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
            "adminCorrect"         => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "text"     => "test",
                "hasError" => false
            ],
            "adminEmpty"           => [
                "user"     => self::TYPE_FULL,
                "id"       => null,
                "text"     => "",
                "hasError" => false
            ],
            "adminIncorrect"       => [
                "user"     => self::TYPE_FULL,
                "id"       => 999,
                "text"     => "test",
                "hasError" => true
            ],
            "userCorrect"          => [
                "user"     => self::TYPE_LIMITED,
                "id"       => null,
                "text"     => "test",
                "hasError" => false
            ],
            "userEmpty"            => [
                "user"     => self::TYPE_LIMITED,
                "id"       => null,
                "text"     => "",
                "hasError" => false
            ],
            "userIncorrect"        => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 999,
                "text"     => "test",
                "hasError" => true
            ],
            "noOperationCorrect"   => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => null,
                "text"     => "test",
                "hasError" => true
            ],
            "noOperationEmpty"     => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => null,
                "text"     => "",
                "hasError" => true
            ],
            "noOperationIncorrect" => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 999,
                "text"     => "test",
                "hasError" => true
            ],
            "blockedCorrect"       => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => null,
                "text"     => "test",
                "hasError" => true
            ],
            "blockedEmpty"         => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => null,
                "text"     => "",
                "hasError" => true
            ],
            "blockedIncorrect"     => [
                "user"     => self::TYPE_BLOCKED_USER,
                "id"       => 999,
                "text"     => "test",
                "hasError" => true
            ],
            "guestCorrect"         => [
                "user"     => null,
                "id"       => null,
                "text"     => "test",
                "hasError" => true
            ],
            "guestEmpty"           => [
                "user"     => null,
                "id"       => null,
                "text"     => "",
                "hasError" => true
            ],
            "guestIncorrect"       => [
                "user"     => null,
                "id"       => 999,
                "text"     => "test",
                "hasError" => true
            ],
        ];
    }
}