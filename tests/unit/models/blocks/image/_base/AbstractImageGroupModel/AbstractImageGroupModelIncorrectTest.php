<?php

namespace ss\tests\unit\models\blocks\image\_base\AbstractImageGroupModel;

use ss\models\blocks\image\ImageGroupModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'imageId' => 'incorrect',
                    'seoModel' => [
                        'name' => 'incorrect'
                    ],
                    'sort'    => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'imageId' => '1 asda',
                    'seoModel' => [
                        'name' => '<b>incorrect</b'
                    ],
                    'sort'    => ' 21 asd',
                ],
                [
                    'imageId' => 1,
                    'seoModel' => [
                        'name' => 'incorrect'
                    ],
                    'sort'    => 21,
                ],
                [
                    'seoModel' => [
                        'name' => $this->generateStringWithLength(256)
                    ],
                ],
                [
                    'seoModel' => [
                        'name' => ['maxLength'],
                    ],
                ]
            ],
            'incorrect3' => [
                [
                    'imageId' => 999,
                    'seoModel' => [
                        'name' => 'Name'
                    ],
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
