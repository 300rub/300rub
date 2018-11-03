<?php

namespace ss\tests\phpunit\controllers\image;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetDesignController
 */
class GetDesignControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param bool   $hasError Error flag
     * @param array  $expected Expected
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testGetDesign($user, $blockId, $hasError, $expected)
    {
        $this->setUser($user);

        $this->sendRequest('image', 'design', ['id' => $blockId]);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody());

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
            'userSimple'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 3,
                'hasError' => false,
                'expected' => [
                    'id'         => 3,
                    'group'      => 'image',
                    'controller' => 'design',
                    'list'       => [
                        [
                            'title' => 'Image design',
                            'data'  => $this->_userSimpleData()
                        ]
                    ],
                    'labels'     => [
                        'button' => 'Save'
                    ]
                ]
            ],
            'userZoom'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 5,
                'hasError' => false,
                'expected' => [
                    'id'         => 5,
                    'group'      => 'image',
                    'controller' => 'design',
                    'list'       => [
                        [
                            'title' => 'Image design',
                            'data'  => $this->_userZoomData()
                        ]
                    ],
                    'labels'     => [
                        'button' => 'Save'
                    ]
                ]
            ],
            'noOperationSimple' => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'id'       => 3,
                'hasError' => true,
                'expected' => []
            ]
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _userSimpleData()
    {
        return [
            [
                'selector'       => '.block-3',
                'cssContainerId' => 'block-3-block',
                'type'           => 'block',
                'namespace'      => 'designBlockModel',
                'values'         => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector'       => '.image-1',
                'cssContainerId' => 'image-1-block',
                'type'           => 'block',
                'namespace'
                                 => 'designImageSimpleModel.containerDesignBlockModel',
                'values'         => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector'       => '.image-1 .image-instance',
                'cssContainerId' => 'image-1-image-instance-block',
                'type'           => 'block',
                'namespace'      => 'designImageSimpleModel.imageDesignBlockModel',
                'values'         => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector'       => '.image-1',
                'cssContainerId' => 'image-1-image-simple',
                'type'           => 'image-simple',
                'namespace'      => 'designImageSimpleModel',
                'values'         => [
                    'alignment' => 0
                ]
            ]
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _userZoomData()
    {
        return [
            [
                'selector'       => '.block-5',
                'cssContainerId' => 'block-5-block',
                'type'           => 'block',
                'namespace'      => 'designBlockModel',
                'values'         => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector'       => '.image-3',
                'cssContainerId' => 'image-3-block',
                'type'           => 'block',
                'namespace'      => 'designImageZoomModel.designBlockModel',
                'values'         => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector'       => '.image-3',
                'cssContainerId' => 'image-3-image-zoom',
                'type'           => 'image-zoom',
                'namespace'      => 'designImageZoomModel',
                'values'         => [
                    'effect' => 0,
                ]
            ]
        ];
    }
}
