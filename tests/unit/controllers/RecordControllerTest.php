<?php

namespace testS\tests\unit\controllers;

use testS\models\BlockModel;
use testS\models\RecordModel;

/**
 * Tests for the controller RecordController
 *
 * @package testS\tests\unit\controllers
 */
class RecordControllerTest extends AbstractControllerTest
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
     * @param bool   $hasClones
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
        $canUpdateSettings = null,
        $hasClones = false
    ) {
        $this->setUser($user);
        $this->sendRequest("record", "blocks", ["displayBlocksFromSection" => $displayBlocksFromSection]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $this->assertTrue(strlen($body["title"]) > 0);
        $this->assertTrue(strlen($body["description"]) > 0);
        $this->assertSame("block", $body["back"]["controller"]);
        $this->assertSame("blocks", $body["back"]["action"]);
        $this->assertSame("record", $body["settings"]["controller"]);
        $this->assertSame("block", $body["settings"]["action"]);
        $this->assertSame("record", $body["design"]["controller"]);
        $this->assertSame("design", $body["design"]["action"]);
        $this->assertSame("record", $body["content"]["controller"]);
        $this->assertSame("content", $body["content"]["action"]);

        $this->assertSame($canAdd, $body["canAdd"]);

        if ($hasResult === false) {
            $this->assertSame(0, count($body["list"]));
            return true;
        } else {
            $this->assertTrue(count($body["list"]) > 0);
            $this->assertSame($hasClones, count($body["list"][0]["clones"]) > 0);
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
            "limitedViewAll"                 => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "hasResult"                => true,
                "canAdd"                   => true,
                "canUpdateDesign"          => true,
                "catUpdateContent"         => true,
                "canUpdateSettings"        => true,
                "hasClones"                => true,
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
                "hasClones"                => false,
            ],
            "limitedViewFromNonexistentPage" => [
                "user"                     => self::TYPE_LIMITED,
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
        ];
    }

    /**
     * Test for method getBlock
     *
     * @param string $user
     * @param int    $id
     * @param bool   $hasError
     * @param array $expected
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetBlock
     */
    public function testGetBlock($user, $id, $hasError, array $expected = [])
    {
        $this->setUser($user);
        $this->sendRequest("record", "block", ["id" => $id]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        $expected = [
            "id"          => $id,
            "title"       => $expected["title"],
            "forms"       => [
                "name"               => [
                    "name"       => "name",
                    "validation" => [],
                    "value"      => $expected["name"],
                ],
                "hasCover"           => [
                    "name"  => "hasCover",
                    "value" => $expected["hasCover"],
                ],
                "hasImages"          => [
                    "name"  => "hasImages",
                    "value" => $expected["hasImages"],
                ],
                "hasCoverZoom"       => [
                    "name"  => "hasCoverZoom",
                    "value" => $expected["hasCoverZoom"],
                ],
                "hasDescription"     => [
                    "name"  => "hasDescription",
                    "value" => $expected["hasDescription"],
                ],
                "useAutoload"        => [
                    "name"  => "useAutoload",
                    "value" => $expected["useAutoload"],
                ],
                "pageNavigationSize" => [
                    "name"  => "pageNavigationSize",
                    "value" => $expected["pageNavigationSize"],
                ],
                "shortCardDateType"  => [
                    "value" => $expected["shortCardDateType"],
                    "name"  => "shortCardDateType",
                    "list"  => []
                ],
                "fullCardDateType"   => [
                    "value" => $expected["fullCardDateType"],
                    "name"  => "fullCardDateType",
                    "list"  => []
                ],
                "button"             => [
                    "label" => $expected["button"],
                ]
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
            "noOperationAdd"      => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 0,
                "hasError" => true
            ],
            "noOperationEdit6"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 6,
                "hasError" => true,
            ],
            "noOperationEdit8"    => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "id"       => 8,
                "hasError" => true,
            ],
            "userAdd" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 0,
                "hasError" => false,
                "expected" => [
                    "title"              => "Add record",
                    "name"               => "",
                    "hasCover"           => false,
                    "hasImages"          => false,
                    "hasCoverZoom"       => false,
                    "hasDescription"     => false,
                    "useAutoload"        => false,
                    "pageNavigationSize" => 0,
                    "shortCardDateType"  => 0,
                    "fullCardDateType"   => 0,
                    "button"             => "Add",
                ],
            ],
            "userEdit6" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 6,
                "hasError" => false,
                "expected" => [
                    "title"              => "Edit record",
                    "name"               => "Records 1",
                    "hasCover"           => false,
                    "hasImages"          => false,
                    "hasCoverZoom"       => false,
                    "hasDescription"     => false,
                    "useAutoload"        => false,
                    "pageNavigationSize" => 0,
                    "shortCardDateType"  => 0,
                    "fullCardDateType"   => 0,
                    "button"             => "Update",
                ],
            ],
            "userEdit8" => [
                "user"     => self::TYPE_LIMITED,
                "id"       => 8,
                "hasError" => false,
                "expected" => [
                    "title"              => "Edit record",
                    "name"               => "Records 2",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                    "button"             => "Update",
                ],
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
        $recordModelCountBefore = (new RecordModel())->getCount();
        $blockModelCountBefore = (new BlockModel())->getCount();

        $this->setUser($user);
        $this->sendRequest("record", "block", $data, "POST");
        $body = $this->getBody();

        $recordModelCountAfter = (new RecordModel())->getCount();
        $blockModelCountAfter = (new BlockModel())->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame($recordModelCountBefore, $recordModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame($recordModelCountBefore, $recordModelCountAfter);
            $this->assertSame($blockModelCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            "result" => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockRecordModel = (new BlockModel())->latest()->find();
        $recordModel = $blockRecordModel->getContentModel();

        $this->assertSame($data["name"], $blockRecordModel->get("name"));
        $this->assertSame($data["hasCover"], $recordModel->get("hasCover"));
        $this->assertSame($data["hasImages"], $recordModel->get("hasImages"));
        $this->assertSame($data["hasCoverZoom"], $recordModel->get("hasCoverZoom"));
        $this->assertSame($data["hasDescription"], $recordModel->get("hasDescription"));
        $this->assertSame($data["useAutoload"], $recordModel->get("useAutoload"));
        $this->assertSame($data["pageNavigationSize"], $recordModel->get("pageNavigationSize"));
        $this->assertSame($data["shortCardDateType"], $recordModel->get("shortCardDateType"));
        $this->assertSame($data["fullCardDateType"], $recordModel->get("fullCardDateType"));

        $this->assertSame($recordModelCountBefore, $recordModelCountAfter - 1);
        $this->assertSame($blockModelCountBefore, $blockModelCountAfter - 1);

        $blockRecordModel->delete();

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
            "userEmptyName"                  => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => false,
                "hasValidationErrors" => true,
            ],
            "noOperationUser"                => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError" => true,
            ],
            "userWithoutHasCover"                => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectHasCover"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"              => "Block name",
                    "hasCover"           => "incorrect",
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutHasImages"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectHasImages"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => "incorrect",
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutHasCoverZoom"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectHasCoverZoom"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => "incorrect",
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutHasDescription"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectHasDescription"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => "incorrect",
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutUseAutoload"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectUseAutoload"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => "incorrect",
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutPageNavigationSize"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectPageNavigationSize"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => "incorrect",
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutShortCardDateType"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectShortCardDateType"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => "incorrect",
                    "fullCardDateType"   => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userWithoutFullCardDateType"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userIncorrectFullCardDateType"              => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => "incorrect",
                ],
                "hasError"            => true,
                "hasValidationErrors" => false,
            ],
            "userCorrect"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
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
        $recordModel = new RecordModel();
        $recordModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => "name",
                "language"    => 1,
                "contentType" => BlockModel::TYPE_RECORD,
                "contentId"   => $recordModel->getId(),
            ]
        );
        $blockModel->save();

        $data["id"] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest("record", "block", $data, "PUT");
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

        $recordModel = (new RecordModel())->byId($recordModel->getId())->find();
        $blockModel = BlockModel::getById($blockModel->getId());

        $this->assertSame($data["name"], $blockModel->get("name"));
        $this->assertSame($data["hasCover"], $recordModel->get("hasCover"));
        $this->assertSame($data["hasImages"], $recordModel->get("hasImages"));
        $this->assertSame($data["hasCoverZoom"], $recordModel->get("hasCoverZoom"));
        $this->assertSame($data["hasDescription"], $recordModel->get("hasDescription"));
        $this->assertSame($data["useAutoload"], $recordModel->get("useAutoload"));
        $this->assertSame($data["pageNavigationSize"], $recordModel->get("pageNavigationSize"));
        $this->assertSame($data["shortCardDateType"], $recordModel->get("shortCardDateType"));
        $this->assertSame($data["fullCardDateType"], $recordModel->get("fullCardDateType"));

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
            "noOperationUser"                => [
                "user"     => self::TYPE_NO_OPERATIONS_USER,
                "data"     => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
                ],
                "hasError" => true,
            ],
            "userCorrect"                    => [
                "user"                => self::TYPE_LIMITED,
                "data"                => [
                    "name"               => "Block name",
                    "hasCover"           => true,
                    "hasImages"          => true,
                    "hasCoverZoom"       => true,
                    "hasDescription"     => true,
                    "useAutoload"        => true,
                    "pageNavigationSize" => 20,
                    "shortCardDateType"  => 1,
                    "fullCardDateType"   => 1,
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
            $recordModel = new RecordModel();
            $recordModel->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    "name"        => "name",
                    "language"    => 1,
                    "contentType" => BlockModel::TYPE_RECORD,
                    "contentId"   => $recordModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        } else {
            $requestId = $id;
        }

        $this->sendRequest("record", "block", ["id" => $requestId], "DELETE");

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

    public function testCreateBlockDuplication()
    {
        $this->markTestSkipped();
    }

    public function testGetCloneBlock()
    {
        $this->markTestSkipped();
    }

    public function testCreateCloneBlock()
    {
        $this->markTestSkipped();
    }

    public function testUpdateCloneBlock()
    {
        $this->markTestSkipped();
    }

    public function testDeleteCloneBlock()
    {
        $this->markTestSkipped();
    }

    public function testCreateCloneBlockDuplication()
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

    public function testGetCloneDesign()
    {
        $this->markTestSkipped();
    }

    public function testUpdateCloneDesign()
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

    public function testCreateRecord()
    {
        $this->markTestSkipped();
    }

    public function testGetRecord()
    {
        $this->markTestSkipped();
    }

    public function testUpdateRecord()
    {
        $this->markTestSkipped();
    }

    public function testDeleteRecord()
    {
        $this->markTestSkipped();
    }
}