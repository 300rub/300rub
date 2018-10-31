<?php

namespace ss\tests\phpunit\controllers\text;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetBlockController
 */
class GetBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user      User type
     * @param int    $blockId   Block ID
     * @param bool   $hasError  Error flag
     * @param string $title     Title
     * @param string $name      Name
     * @param int    $type      Type
     * @param bool   $hasEditor Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $blockId,
        $hasError,
        $title = null,
        $name = null,
        $type = null,
        $hasEditor = null
    ) {
        $this->setUser($user);
        $this->sendRequest('text', 'block', ['id' => $blockId]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expected = [
            'id'    => $blockId,
            'title' => $title,
            'forms' => [
                'name'      => [
                    'name'       => 'name',
                    'label'      => 'Name',
                    'validation' => [],
                    'value'      => $name,
                ],
                'type'      => [
                    'label' => 'Type',
                    'value' => $type,
                    'name'  => 'type',
                    'list'  => []
                ],
                'hasEditor' => [
                    'name'  => 'hasEditor',
                    'label' => 'Has editor',
                    'value' => $hasEditor,
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
    public function dataProvider()
    {
        return array_merge(
            $this->_dataProvider1(),
            $this->_dataProvider2()
        );
    }

    /**
     * Data provider for testGetBlock
     *
     * @return array
     */
    private function _dataProvider1()
    {
        return [
            'ownerAdd'            => [
                'user'      => self::TYPE_OWNER,
                'id'        => 0,
                'hasError'  => false,
                'title'     => 'Add text',
                'name'      => '',
                'type'      => 0,
                'hasEditor' => false
            ],
            'ownerEdit1'          => [
                'user'      => self::TYPE_OWNER,
                'id'        => 1,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Simple text',
                'type'      => 0,
                'hasEditor' => false
            ],
            'ownerEdit2'          => [
                'user'      => self::TYPE_OWNER,
                'id'        => 2,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Text with editor',
                'type'      => 0,
                'hasEditor' => true
            ],
            'ownerEdit9999'       => [
                'user'     => self::TYPE_OWNER,
                'id'       => 9999,
                'hasError' => true
            ],
            'adminAdd'            => [
                'user'      => self::TYPE_FULL,
                'id'        => 0,
                'hasError'  => false,
                'title'     => 'Add text',
                'name'      => '',
                'type'      => 0,
                'hasEditor' => false
            ],
            'adminEdit1'          => [
                'user'      => self::TYPE_FULL,
                'id'        => 1,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Simple text',
                'type'      => 0,
                'hasEditor' => false
            ],
            'adminEdit2'          => [
                'user'      => self::TYPE_FULL,
                'id'        => 2,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Text with editor',
                'type'      => 0,
                'hasEditor' => true
            ],
            'adminEdit9999'       => [
                'user'     => self::TYPE_FULL,
                'id'       => 9999,
                'hasError' => true
            ],
        ];
    }

    /**
     * Data provider for testGetBlock
     *
     * @return array
     */
    private function _dataProvider2()
    {
        return [
            'guestAdd'            => [
                'user'     => null,
                'id'       => 0,
                'hasError' => true
            ],
            'guestEdit1'          => [
                'user'     => null,
                'id'       => 1,
                'hasError' => true,
            ],
            'guestEdit2'          => [
                'user'     => null,
                'id'       => 2,
                'hasError' => true,
            ],
            'guestEdit9999'       => [
                'user'     => null,
                'id'       => 9999,
                'hasError' => true
            ],
            'blockedAdd'          => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 0,
                'hasError' => true
            ],
            'blockedEdit1'        => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 1,
                'hasError' => true,
            ],
            'blockedEdit2'        => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 2,
                'hasError' => true,
            ],
            'blockedEdit9999'     => [
                'user'     => self::TYPE_BLOCKED_USER,
                'id'       => 9999,
                'hasError' => true
            ],
            'noOperationAdd'      => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 0,
                'hasError' => true
            ],
            'noOperationEdit1'    => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 1,
                'hasError' => true,
            ],
            'noOperationEdit2'    => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 2,
                'hasError' => true,
            ],
            'noOperationEdit9999' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 9999,
                'hasError' => true
            ],
            'userAdd'             => [
                'user'      => self::TYPE_LIMITED,
                'id'        => 0,
                'hasError'  => false,
                'title'     => 'Add text',
                'name'      => '',
                'type'      => 0,
                'hasEditor' => false
            ],
            'userEdit1'           => [
                'user'      => self::TYPE_LIMITED,
                'id'        => 1,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Simple text',
                'type'      => 0,
                'hasEditor' => false
            ],
            'userEdit2'           => [
                'user'      => self::TYPE_LIMITED,
                'id'        => 2,
                'hasError'  => false,
                'title'     => 'Edit text',
                'name'      => 'Text with editor',
                'type'      => 0,
                'hasEditor' => true
            ],
            'userEdit9999'        => [
                'user'     => self::TYPE_LIMITED,
                'id'       => 9999,
                'hasError' => true
            ],
        ];
    }
}
