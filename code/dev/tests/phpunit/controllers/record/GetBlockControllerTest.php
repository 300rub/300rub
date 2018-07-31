<?php

namespace ss\tests\phpunit\controllers\record;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetBlockController
 */
class GetBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param bool   $hasError Error flag
     * @param array  $expected Expected data
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($user, $blockId, $hasError, array $expected = [])
    {
        $this->setUser($user);
        $this->sendRequest('record', 'block', ['id' => $blockId]);
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expected = [
            'id'    => $blockId,
            'title' => $expected['title'],
            'forms' => [
                'name'               => [
                    'name'       => 'name',
                    'validation' => [],
                    'value'      => $expected['name'],
                ],
                'hasCover'           => [
                    'name'  => 'hasCover',
                    'value' => $expected['hasCover'],
                ],
                'hasImages'          => [
                    'name'  => 'hasImages',
                    'value' => $expected['hasImages'],
                ],
                'hasCoverZoom'       => [
                    'name'  => 'hasCoverZoom',
                    'value' => $expected['hasCoverZoom'],
                ],
                'hasDescription'     => [
                    'name'  => 'hasDescription',
                    'value' => $expected['hasDescription'],
                ],
                'useAutoload'        => [
                    'name'  => 'useAutoload',
                    'value' => $expected['useAutoload'],
                ],
                'pageNavigationSize' => [
                    'name'  => 'pageNavigationSize',
                    'value' => $expected['pageNavigationSize'],
                ],
                'shortCardDateType'  => [
                    'value' => $expected['shortCardDateType'],
                    'name'  => 'shortCardDateType',
                    'list'  => []
                ],
                'fullCardDateType'   => [
                    'value' => $expected['fullCardDateType'],
                    'name'  => 'fullCardDateType',
                    'list'  => []
                ],
                'button'             => [
                    'label' => $expected['button'],
                ]
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
            'noOperationAdd'   => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 0,
                'hasError' => true
            ],
            'noOperationEdit6' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 6,
                'hasError' => true,
            ],
            'noOperationEdit8' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 8,
                'hasError' => true,
            ],
            'userAdd'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 0,
                'hasError' => false,
                'expected' => [
                    'title'              => 'Add record',
                    'name'               => '',
                    'hasCover'           => false,
                    'hasImages'          => false,
                    'hasCoverZoom'       => false,
                    'hasDescription'     => false,
                    'useAutoload'        => false,
                    'pageNavigationSize' => 0,
                    'shortCardDateType'  => 0,
                    'fullCardDateType'   => 0,
                    'button'             => 'Add',
                ],
            ],
            'userEdit6'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 6,
                'hasError' => false,
                'expected' => [
                    'title'              => 'Edit record',
                    'name'               => 'Records 1',
                    'hasCover'           => false,
                    'hasImages'          => false,
                    'hasCoverZoom'       => false,
                    'hasDescription'     => false,
                    'useAutoload'        => false,
                    'pageNavigationSize' => 0,
                    'shortCardDateType'  => 0,
                    'fullCardDateType'   => 0,
                    'button'             => 'Update',
                ],
            ],
            'userEdit8'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 8,
                'hasError' => false,
                'expected' => [
                    'title'              => 'Edit record',
                    'name'               => 'Records 2',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                    'button'             => 'Update',
                ],
            ],
            'userEdit9999'     => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 9999,
                'hasError' => true
            ],
        ];
    }
}
