<?php

namespace ss\tests\unit\controllers\image;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateDesignController
 */
class UpdateDesignControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param array  $data     Data
     * @param bool   $hasError Error flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testUpdateDesign($user, $blockId, $data, $hasError)
    {
        $blockModel = null;
        $requestId = $blockId;
        if ($blockId === null) {
            $imageModel = ImageModel::model()->save();

            $blockModel = new BlockModel();
            $blockModel->set(
                [
                    'name'        => 'name',
                    'language'    => 1,
                    'contentType' => BlockModel::TYPE_IMAGE,
                    'contentId'   => $imageModel->getId(),
                ]
            );
            $blockModel->save();

            $requestId = $blockModel->getId();
        }

        $this->setUser($user);
        $this->sendRequest(
            'image',
            'design',
            array_merge(
                $data,
                [
                    'id' => $requestId
                ]
            ),
            'PUT'
        );
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();

            if ($blockId === null) {
                $blockModel->delete();
            }

            return true;
        }

        $this->assertTrue($body['result']);

        $blockModel->delete();
        return true;
    }

    /**
     * Data provider
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
     * Data provider
     *
     * @return array
     */
    private function _dataProvider1()
    {
        return [
            'userCorrectSimple' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel'       => [
                        'marginTop' => 10
                    ],
                    'designImageSimpleModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 20
                        ],
                        'imageDesignBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'alignment'                 => 1
                    ]
                ],
                'hasError' => false
            ],
            'userCorrectZoom'   => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel'     => [
                        'marginTop' => 10
                    ],
                    'designImageZoomModel' => [
                        'designBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'hasScroll'            => true,
                        'thumbsAlignment'      => 1,
                        'descriptionAlignment' => 1,
                        'effect'               => 0,
                    ]
                ],
                'hasError' => false
            ],
            'userCorrectSlider' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel'     => [
                        'marginTop' => 10
                    ],
                    'designImageZoomModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 20
                        ],
                        'navigationDesignBlockModel'  => [
                            'marginTop' => 20
                        ],
                        'descriptionDesignBlockModel' => [
                            'marginTop' => 20
                        ],
                        'effect'                      => 0,
                        'hasAutoPlay'                 => true,
                        'playSpeed'                   => 5,
                        'navigationAlignment'         => 1,
                        'descriptionAlignment'        => 1,
                    ]
                ],
                'hasError' => false
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider2()
    {
        return [
            'userInCorrect'     => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel' => [
                        'marginTop' => 10
                    ],
                ],
                'hasError' => true
            ],
            'userIncorrectId'   => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 999,
                'data'     => [
                    'designBlockModel'       => [
                        'marginTop' => 10
                    ],
                    'designImageSimpleModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 20
                        ],
                        'imageDesignBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'alignment'                 => 1
                    ]
                ],
                'hasError' => true
            ],
            'noOperation'       => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => null,
                'data'     => [
                    'designBlockModel'       => [
                        'marginTop' => 10
                    ],
                    'designImageSimpleModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 20
                        ],
                        'imageDesignBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'alignment'                 => 1
                    ]
                ],
                'hasError' => true
            ],
        ];
    }
}
