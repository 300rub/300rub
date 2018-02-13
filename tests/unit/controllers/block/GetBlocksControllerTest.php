<?php

namespace ss\tests\unit\controllers\block;

use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetBlocksController
 */
class GetBlocksControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user         User
     * @param int    $blockSection Block section
     * @param bool   $hasError     Flag of error
     * @param bool   $isEmptyList  Flag of empty list
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $blockSection,
        $hasError,
        $isEmptyList
    ) {
        $this->setUser($user);
        $this->sendRequest(
            'block',
            'blocks',
            [
                'blockSection' => $blockSection
            ]
        );

        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        if ($isEmptyList === true) {
            $this->assertTrue(count($body['list']) === 0);
            return true;
        }

        $this->assertTrue(count($body['list']) > 0);
        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'adminAll' => [
                'user'         => self::TYPE_FULL,
                'blockSection' => 0,
                'hasError'     => false,
                'isEmptyList'  => false
            ],
            'admin1' => [
                'user'         => self::TYPE_FULL,
                'blockSection' => 1,
                'hasError'     => false,
                'isEmptyList'  => false
            ],
            'admin999' => [
                'user'         => self::TYPE_FULL,
                'blockSection' => 999,
                'hasError'     => false,
                'isEmptyList'  => true
            ],
            'userAll' => [
                'user'         => self::TYPE_LIMITED,
                'blockSection' => 0,
                'hasError'     => false,
                'isEmptyList'  => false
            ],
            'user1' => [
                'user'         => self::TYPE_LIMITED,
                'blockSection' => 1,
                'hasError'     => false,
                'isEmptyList'  => false
            ],
            'user999' => [
                'user'         => self::TYPE_LIMITED,
                'blockSection' => 999,
                'hasError'     => false,
                'isEmptyList'  => true
            ],
            'noOperationAll' => [
                'user'         => self::TYPE_NO_OPERATIONS_USER,
                'blockSection' => 0,
                'hasError'     => false,
                'isEmptyList'  => true
            ],
            'noOperation1' => [
                'user'         => self::TYPE_NO_OPERATIONS_USER,
                'blockSection' => 1,
                'hasError'     => false,
                'isEmptyList'  => true
            ],
            'noOperation999' => [
                'user'         => self::TYPE_NO_OPERATIONS_USER,
                'blockSection' => 999,
                'hasError'     => false,
                'isEmptyList'  => true
            ],
            'blockedAll' => [
                'user'         => self::TYPE_BLOCKED_USER,
                'blockSection' => 0,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
            'blocked1' => [
                'user'         => self::TYPE_BLOCKED_USER,
                'blockSection' => 1,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
            'blocked999' => [
                'user'         => self::TYPE_BLOCKED_USER,
                'blockSection' => 999,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
            'guestAll' => [
                'user'         => null,
                'blockSection' => 0,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
            'guest1' => [
                'user'         => null,
                'blockSection' => 1,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
            'guest999' => [
                'user'         => null,
                'blockSection' => 999,
                'hasError'     => true,
                'isEmptyList'  => true
            ],
        ];
    }
}
