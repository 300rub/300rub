<?php

namespace ss\tests\phpunit\controllers\image;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetBlockController
 */
class GetBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param array $data Data
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun($data)
    {
        $this->setUser($data['user']);
        $this->sendRequest('image', 'block', ['id' => $data['blockId']]);
        $body = $this->getBody();

        if ($data['hasError'] === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expected = [
            'id'    => $data['blockId'],
            'title' => $data['title'],
            'forms' => [
                'name'              => [
                    'name'       => 'name',
                    'validation' => [],
                    'value'      => $data['name'],
                ],
                'type'              => [
                    'value' => $data['type'],
                    'name'  => 'type',
                    'list'  => []
                ],
                'viewAutoCropType'  => [
                    'value' => $data['viewAutoCropType'],
                    'name'  => 'viewAutoCropType',
                    'list'  => []
                ],
                'viewCropX'         => [
                    'name'  => 'viewCropX',
                    'value' => $data['viewCropX'],
                ],
                'viewCropY'         => [
                    'name'  => 'viewCropY',
                    'value' => $data['viewCropY'],
                ],
                'thumbAutoCropType' => [
                    'value' => $data['thumbAutoCropType'],
                    'name'  => 'thumbAutoCropType',
                    'list'  => []
                ],
                'useAlbums'         => [
                    'name'  => 'useAlbums',
                    'value' => $data['useAlbums'],
                ],
                'thumbCropX'        => [
                    'name'  => 'thumbCropX',
                    'value' => $data['thumbCropX'],
                ],
                'thumbCropY'        => [
                    'name'  => 'thumbCropY',
                    'value' => $data['thumbCropY'],
                ],
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
            'noOperationAdd'      => [
                'data' => [
                    'user'     => self::TYPE_NO_OPERATIONS_USER,
                    'blockId'  => 0,
                    'hasError' => true
                ]
            ],
            'noOperationEdit3'    => [
                'data' => [
                    'user'     => self::TYPE_NO_OPERATIONS_USER,
                    'blockId'  => 3,
                    'hasError' => true,
                ]
            ],
            'noOperationEdit4'    => [
                'data' => [
                    'user'     => self::TYPE_NO_OPERATIONS_USER,
                    'blockId'  => 4,
                    'hasError' => true,
                ]
            ],
            'noOperationEdit9999' => [
                'data' => [
                    'user'     => self::TYPE_NO_OPERATIONS_USER,
                    'blockId'  => 9999,
                    'hasError' => true
                ]
            ],
            'userAdd'             => [
                'data' => [
                    'user'              => self::TYPE_LIMITED,
                    'blockId'           => 0,
                    'hasError'          => false,
                    'title'             => 'Add image',
                    'name'              => '',
                    'type'              => 0,
                    'viewAutoCropType'  => 0,
                    'viewCropX'         => 0,
                    'viewCropY'         => 0,
                    'thumbAutoCropType' => 0,
                    'useAlbums'         => false,
                    'thumbCropX'        => 0,
                    'thumbCropY'        => 0,
                ]
            ],
            'userEdit3'           => [
                'data' => [
                    'user'              => self::TYPE_LIMITED,
                    'blockId'           => 3,
                    'hasError'          => false,
                    'title'             => 'Edit image',
                    'name'              => 'Zoom image',
                    'type'              => 0,
                    'viewAutoCropType'  => 0,
                    'viewCropX'         => 0,
                    'viewCropY'         => 0,
                    'thumbAutoCropType' => 0,
                    'useAlbums'         => false,
                    'thumbCropX'        => 0,
                    'thumbCropY'        => 0,
                ]
            ],
            'userEdit4'           => [
                'data' => [
                    'user'              => self::TYPE_LIMITED,
                    'blockId'           => 4,
                    'hasError'          => false,
                    'title'             => 'Edit image',
                    'name'              => 'Slider image',
                    'type'              => 1,
                    'viewAutoCropType'  => 5,
                    'viewCropX'         => 3,
                    'viewCropY'         => 4,
                    'thumbAutoCropType' => 8,
                    'useAlbums'         => true,
                    'thumbCropX'        => 1,
                    'thumbCropY'        => 2,
                ]
            ],
            'userEdit9999'        => [
                'data' => [
                    'user'     => self::TYPE_LIMITED,
                    'blockId'  => 9999,
                    'hasError' => true
                ]
            ],
        ];
    }
}
