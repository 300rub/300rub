<?php

namespace testS\tests\unit\controllers;

/**
 * Tests for the controller BlockController
 *
 * @package testS\tests\unit\controllers
 */
class BlockControllerTest extends AbstractControllerTest
{

    /**
     * Test for the method getBlocks
     *
     * @param string $user
     * @param int    $displayBlocksFromSection
     * @param bool   $hasError
     * @param bool   $isEmptyList
     *
     * @return bool
     *
     * @dataProvider dataProviderForTestGetBlocks
     */
    public function testGetBlocks($user, $displayBlocksFromSection, $hasError, $isEmptyList = false)
    {
        $this->setUser($user);
        $this->sendRequest("text", "blocks", ["displayBlocksFromSection" => $displayBlocksFromSection]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey("error", $body);
            return true;
        }

        if ($isEmptyList === true) {
            $this->assertTrue(count($body["list"]) === 0);
        } else {
            $this->assertTrue(count($body["list"]) > 0);
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
            "adminAll" => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "isEmptyList"              => false
            ],
            "admin1" => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "isEmptyList"              => false
            ],
            "admin999" => [
                "user"                     => self::TYPE_FULL,
                "displayBlocksFromSection" => 999,
                "hasError"                 => false,
                "isEmptyList"              => true
            ],
            "userAll" => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "isEmptyList"              => false
            ],
            "user1" => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "isEmptyList"              => false
            ],
            "user999" => [
                "user"                     => self::TYPE_LIMITED,
                "displayBlocksFromSection" => 999,
                "hasError"                 => false,
                "isEmptyList"              => true
            ],
            "noOperationAll" => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 0,
                "hasError"                 => false,
                "isEmptyList"              => true
            ],
            "noOperation1" => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 1,
                "hasError"                 => false,
                "isEmptyList"              => true
            ],
            "noOperation999" => [
                "user"                     => self::TYPE_NO_OPERATIONS_USER,
                "displayBlocksFromSection" => 999,
                "hasError"                 => false,
                "isEmptyList"              => true
            ],
            "blockedAll" => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 0,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
            "blocked1" => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 1,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
            "blocked999" => [
                "user"                     => self::TYPE_BLOCKED_USER,
                "displayBlocksFromSection" => 999,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
            "guestAll" => [
                "user"                     => null,
                "displayBlocksFromSection" => 0,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
            "guest1" => [
                "user"                     => null,
                "displayBlocksFromSection" => 1,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
            "guest999" => [
                "user"                     => null,
                "displayBlocksFromSection" => 999,
                "hasError"                 => true,
                "isEmptyList"              => true
            ],
        ];
    }
}