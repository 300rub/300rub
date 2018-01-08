<?php

namespace testS\tests\unit\controllers\image;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

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
                    'controller' => 'image',
                    'action'     => 'design',
                    'list'       => [
                        [
                            'title' => 'Image design',
                            'data'  => $this->_userSimpleData()
                        ]
                    ],
                    'button'     => [
                        'label' => 'Save'
                    ]
                ]
            ],
            'userSlider'        => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 4,
                'hasError' => false,
                'expected' => [
                    'id'         => 4,
                    'controller' => 'image',
                    'action'     => 'design',
                    'list'       => [
                        [
                            'title' => 'Image design',
                            'data'  => $this->_userSliderData()
                        ]
                    ],
                    'button'     => [
                        'label' => 'Save'
                    ]
                ]
            ],
            'userZoom'          => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 5,
                'hasError' => false,
                'expected' => [
                    'id'         => 5,
                    'controller' => 'image',
                    'action'     => 'design',
                    'list'       => [
                        [
                            'title' => 'Image design',
                            'data'  => $this->_userZoomData()
                        ]
                    ],
                    'button'     => [
                        'label' => 'Save'
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
                'selector' => '.block-3',
                'id' => 'block-3-block',
                'type' => 'block',
                'namespace' => 'designBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-1',
                'id' => 'image-1-block',
                'type' => 'block',
                'namespace'
                    => 'designImageSimpleModel.containerDesignBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-1 .image-instance',
                'id' => 'image-1-image-instance-block',
                'type' => 'block',
                'namespace' => 'designImageSimpleModel.imageDesignBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-1',
                'id' => 'image-1-image-simple',
                'type' => 'image-simple',
                'namespace' => 'designImageSimpleModel',
                'values' => [
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
    private function _userSliderData()
    {
        return [
            [
                'selector' => '.block-4',
                'id' => 'block-4-block',
                'type' => 'block',
                'namespace' => 'designBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-2',
                'id' => 'image-2-block',
                'type' => 'block',
                'namespace'
                    => 'designImageSliderModel.containerDesignBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-2 .navigation',
                'id' => 'image-2-navigation-block',
                'type' => 'block',
                'namespace'
                    => 'designImageSliderModel.navigationDesignBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-2 .description',
                'id' => 'image-2-description-block',
                'type' => 'block',
                'namespace'
                    => 'designImageSliderModel.descriptionDesignBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-2',
                'id' => 'image-2-image-slider',
                'type' => 'image-slider',
                'namespace' => 'designImageSliderModel',
                'values' => [
                    'effect'               => 0,
                    'hasAutoPlay'          => false,
                    'playSpeed'            => 0,
                    'navigationAlignment'  => 0,
                    'descriptionAlignment' => 0,
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
                'selector' => '.block-5',
                'id' => 'block-5-block',
                'type' => 'block',
                'namespace' => 'designBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-3',
                'id' => 'image-3-block',
                'type' => 'block',
                'namespace' => 'designImageZoomModel.designBlockModel',
                'values' => [
                    'marginTop' => 0
                ]
            ],
            [
                'selector' => '.image-3',
                'id' => 'image-3-image-zoom',
                'type' => 'image-zoom',
                'namespace' => 'designImageZoomModel',
                'values' => [
                    'hasScroll'            => false,
                    'thumbsAlignment'      => 0,
                    'descriptionAlignment' => 0,
                    'effect'               => 0,
                ]
            ]
        ];
    }
}
