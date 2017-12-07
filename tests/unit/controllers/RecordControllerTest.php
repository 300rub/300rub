<?php

namespace testS\tests\unit\controllers;

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