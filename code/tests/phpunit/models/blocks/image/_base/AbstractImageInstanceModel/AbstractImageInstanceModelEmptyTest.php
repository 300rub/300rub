<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageInstanceModel;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractImageInstanceModel
 */
class AbstractImageInstanceModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return ImageInstanceModel
     */
    protected function getNewModel()
    {
        return new ImageInstanceModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'originalFileModel' => [
                        'uniqueName' => ['required'],
                    ],
                    'viewFileModel' => [
                        'uniqueName' => ['required'],
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => ['required'],
                    ]
                ],
            ],
            'empty2' => [
                [
                    'imageGroupId'      => '',
                    'originalFileModel' => '',
                    'viewFileModel'     => '',
                    'thumbFileModel'    => '',
                    'isCover'           => '',
                    'sort'              => '',
                    'alt'               => '',
                    'width'             => '',
                    'height'            => '',
                    'viewX'             => '',
                    'viewY'             => '',
                    'viewWidth'         => '',
                    'viewHeight'        => '',
                    'thumbX'            => '',
                    'thumbY'            => '',
                    'thumbWidth'        => '',
                    'thumbHeight'       => '',
                ],
                [
                    'originalFileModel' => [
                        'uniqueName' => ['required'],
                    ],
                    'viewFileModel'     => [
                        'uniqueName' => ['required'],
                    ],
                    'thumbFileModel'    => [
                        'uniqueName' => ['required'],
                    ],
                ],
            ],
            'empty3' => [
                [
                    'originalFileModel' => [
                        'uniqueName' => 'file7.jpg',
                    ],
                    'viewFileModel' => [
                        'uniqueName' => 'view_file7.jpg',
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => 'thumb_file7.jpg',
                    ]
                ],
                [
                    'originalFileModel' => [
                        'uniqueName' => 'file7.jpg',
                    ],
                    'viewFileModel'     => [
                        'uniqueName' => 'view_file7.jpg',
                    ],
                    'thumbFileModel'    => [
                        'uniqueName' => 'thumb_file7.jpg',
                    ],
                    'isCover'           => false,
                    'sort'              => 0,
                    'alt'               => '',
                    'width'             => 0,
                    'height'            => 0,
                    'viewX'             => 0,
                    'viewY'             => 0,
                    'viewWidth'         => 0,
                    'viewHeight'        => 0,
                    'thumbX'            => 0,
                    'thumbY'            => 0,
                    'thumbWidth'        => 0,
                    'thumbHeight'       => 0,
                ],
            ],
            'empty4' => [
                [
                    'imageGroupId' => 1,
                    'originalFileModel' => [
                        'uniqueName' => uniqid() . '.jpg',
                    ],
                    'viewFileModel' => [
                        'uniqueName' => uniqid() . '.jpg',
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => uniqid() . '.jpg',
                    ]
                ],
                [
                    'imageGroupId' => 1,
                    'isCover'      => false,
                    'sort'         => 0,
                    'alt'          => '',
                    'width'        => 0,
                    'height'       => 0,
                    'viewX'        => 0,
                    'viewY'        => 0,
                    'viewWidth'    => 0,
                    'viewHeight'   => 0,
                    'thumbX'       => 0,
                    'thumbY'       => 0,
                    'thumbWidth'   => 0,
                    'thumbHeight'  => 0,
                ],
            ],
        ];
    }
}
