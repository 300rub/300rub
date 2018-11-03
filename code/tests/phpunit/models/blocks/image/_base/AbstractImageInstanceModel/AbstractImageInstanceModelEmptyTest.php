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
                    'imageGroupId' => '',
                    'originalFileModel'    => '',
                    'viewFileModel'    => '',
                    'thumbFileModel'    => '',
                    'isCover'      => '',
                    'sort'         => '',
                    'alt'          => '',
                    'width'        => '',
                    'height'       => '',
                    'x1'           => '',
                    'y1'           => '',
                    'x2'           => '',
                    'y2'           => '',
                    'thumbX1'      => '',
                    'thumbY1'      => '',
                    'thumbX2'      => '',
                    'thumbY2'      => '',
                ],
                [
                    'originalFileModel' => [
                        'uniqueName' => ['required'],
                    ],
                    'viewFileModel' => [
                        'uniqueName' => ['required'],
                    ],
                    'thumbFileModel' => [
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
                    'viewFileModel' => [
                        'uniqueName' => 'view_file7.jpg',
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => 'thumb_file7.jpg',
                    ],
                    'isCover'      => false,
                    'sort'         => 0,
                    'alt'          => '',
                    'width'        => 0,
                    'height'       => 0,
                    'x1'           => 0,
                    'y1'           => 0,
                    'x2'           => 0,
                    'y2'           => 0,
                    'thumbX1'      => 0,
                    'thumbY1'      => 0,
                    'thumbX2'      => 0,
                    'thumbY2'      => 0,
                ],
            ],
            'empty4' => [
                [
                    'imageGroupId' => 1,
                    'originalFileModel' => [
                        'uniqueName' => 'file.jpg',
                    ],
                    'viewFileModel' => [
                        'uniqueName' => 'view_file.jpg',
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => 'thumb_file.jpg',
                    ]
                ],
                [
                    'imageGroupId' => 1,
                    'originalFileModel' => [
                        'uniqueName' => 'file.jpg',
                    ],
                    'viewFileModel' => [
                        'uniqueName' => 'view_file.jpg',
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => 'thumb_file.jpg',
                    ],
                    'isCover'      => false,
                    'sort'         => 0,
                    'alt'          => '',
                    'width'        => 0,
                    'height'       => 0,
                    'x1'           => 0,
                    'y1'           => 0,
                    'x2'           => 0,
                    'y2'           => 0,
                    'thumbX1'      => 0,
                    'thumbY1'      => 0,
                    'thumbX2'      => 0,
                    'thumbY2'      => 0,
                ],
            ],
        ];
    }
}
