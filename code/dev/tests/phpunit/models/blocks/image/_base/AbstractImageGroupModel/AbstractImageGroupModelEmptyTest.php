<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageGroupModel;

use ss\models\blocks\image\ImageGroupModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return ImageGroupModel
     */
    protected function getNewModel()
    {
        return new ImageGroupModel();
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
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'seoModel' => [
                        'name' => 'Name',
                    ]
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'imageId' => '',
                    'name'    => '',
                    'sort'    => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'imageId' => 1,
                    'seoModel' => [
                        'name' => 'Name'
                    ],
                ],
                [
                    'imageId' => 1,
                    'seoModel' => [
                        'name' => 'Name'
                    ],
                    'sort'    => 0,
                ],
            ]
        ];
    }
}
