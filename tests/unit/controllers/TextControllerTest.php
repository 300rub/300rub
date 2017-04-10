<?php

namespace testS\tests\unit\controllers;

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
     */
    public function testGetBlocks()
    {
        $this
            ->_testGetBlocksNoUser()
            ->_testGetBlocksOwnerAllBlocks()
            ->_testGetBlocksOwnerSection1()
            ->_testGetBlocksOwnerSection999()
            ->_testGetBlocksUserWithoutOperations()
            ->_testGetBlocksAddOperations()
            ->_testGetBlocksRemoveOperations();
    }

    /**
     * Test for getBlocks
     *
     * No user
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksNoUser()
    {
        $this->setUser(null);
        $this->sendRequest("text", "blocks");
        $this->assertArrayHasKey("error", $this->getBody());

        return $this;
    }

    /**
     * Test for getBlocks
     *
     * Owner all blocks
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksOwnerAllBlocks()
    {
        $this->setUser(self::TYPE_OWNER);
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => 0]);
        $body = $this->getBody();
        $this->assertTrue(strlen($body["title"]) > 0);
        $this->assertTrue(strlen($body["description"]) > 0);
        $this->assertTrue(count($body["list"]) > 0);
        $this->assertSame("block", $body["back"]["controller"]);
        $this->assertSame("blocks", $body["back"]["action"]);
        $this->assertSame("text", $body["settings"]["controller"]);
        $this->assertSame("block", $body["settings"]["action"]);
        $this->assertSame("text", $body["design"]["controller"]);
        $this->assertSame("design", $body["design"]["action"]);
        $this->assertSame("text", $body["content"]["controller"]);
        $this->assertSame("content", $body["content"]["action"]);
        $this->assertTrue($body["canAdd"]);

        foreach ($body["list"] as $item) {
            $this->assertTrue(strlen($item["blockName"]) > 0);
            $this->assertTrue($item["contentId"] > 0);
            $this->assertTrue($item["canUpdateSettings"]);
            $this->assertTrue($item["canUpdateDesign"]);
            $this->assertTrue($item["canUpdateContent"]);
        }

        return $this;
    }

    /**
     * Test for getBlocks
     *
     * Owner section 1
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksOwnerSection1()
    {
        $this->setUser();
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => 1]);
        $body = $this->getBody();

        $this->assertTrue(count($body["list"]) > 0);

        return $this;
    }

    /**
     * Test for getBlocks
     *
     * Owner section 999
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksOwnerSection999()
    {
        $this->setUser();
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => 999]);
        $body = $this->getBody();

        $this->assertTrue(count($body["list"]) === 0);

        return $this;
    }

    /**
     * Test for getBlocks
     *
     * User without operations
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksUserWithoutOperations()
    {
        $this->setUser(self::TYPE_NO_OPERATIONS_USER);
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => 0]);
        $body = $this->getBody();

        $this->assertTrue(count($body["list"]) === 0);
        $this->assertFalse($body["canAdd"]);

        return $this;
    }

    /**
     * Test for getBlocks
     *
     * Add operations and check
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksAddOperations()
    {
        return $this;
    }

    /**
     * Test for getBlocks
     *
     * Remove user operations
     *
     * @return TextControllerTest
     */
    private function _testGetBlocksRemoveOperations()
    {
        return $this;
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