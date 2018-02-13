<?php

namespace ss\tests\unit\controllers\text;

use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetContentController
 */
class GetContentControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user      User type
     * @param int    $blockId   Block ID
     * @param bool   $hasError  Error flag
     * @param string $name      Name
     * @param int    $type      Type
     * @param bool   $hasEditor Editor flag
     * @param string $value     Value
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $blockId,
        $hasError,
        $name = null,
        $type = null,
        $hasEditor = null,
        $value = null
    ) {
        $this->setUser($user);
        $this->sendRequest('text', 'content', ['id' => $blockId]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expected = [
            'id'        => $blockId,
            'name'      => $name,
            'type'      => $type,
            'hasEditor' => $hasEditor,
            'text'      => [
                'name'  => 'text',
                'label' => 'Text',
                'value' => $value,
            ],
            'button'    => [
                'label' => 'Update',
            ]
        ];

        $this->compareExpectedAndActual($expected, $body);

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
            'admin1'         => [
                'user'      => self::TYPE_FULL,
                'blockId'   => 1,
                'hasError'  => false,
                'name'      => 'Simple text',
                'type'      => 0,
                'hasEditor' => false,
                'value'     => 'Text'
            ],
            'admin0'         => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 0,
                'hasError' => true
            ],
            'admin999'       => [
                'user'     => self::TYPE_FULL,
                'blockId'  => 999,
                'hasError' => true
            ],
            'user1'          => [
                'user'      => self::TYPE_LIMITED,
                'blockId'   => 1,
                'hasError'  => false,
                'name'      => 'Simple text',
                'type'      => 0,
                'hasEditor' => false,
                'value'     => 'Text'
            ],
            'user0'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 0,
                'hasError' => true
            ],
            'user999'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 999,
                'hasError' => true
            ],
            'blocked1'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 1,
                'hasError' => true
            ],
            'blocked0'       => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 0,
                'hasError' => true
            ],
            'blocked999'     => [
                'user'     => self::TYPE_BLOCKED_USER,
                'blockId'  => 999,
                'hasError' => true
            ],
            'noOperation1'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 1,
                'hasError' => true
            ],
            'noOperation0'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 0,
                'hasError' => true
            ],
            'noOperation999' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 999,
                'hasError' => true
            ],
            'guest1'         => [
                'user'     => null,
                'blockId'  => 1,
                'hasError' => true
            ],
            'guest0'         => [
                'user'     => null,
                'blockId'  => 0,
                'hasError' => true
            ],
            'guest999'       => [
                'user'     => null,
                'blockId'  => 999,
                'hasError' => true
            ],
        ];
    }
}
