<?php

namespace testS\tests\unit\controllers;

use testS\applications\App;
use testS\models\UserSessionModel;

/**
 * Tests for the controller TextController
 *
 * @package testS\tests\unit\controllers
 */
class TextControllerTest extends AbstractControllerTest
{

    public function testGetHtml()
    {
        $this->markTestSkipped();
    }

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
            $this->assertTrue(strlen($item["blockName"]) > 0);
            $this->assertTrue($item["contentId"] > 0);
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

    public function testGetBlock()
    {
        $this->markTestSkipped();
    }

    public function testAddBlock()
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
}