<?php

namespace testS\tests\unit\models\blocks\image\_base\AbstractImageGroupModel;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

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
                [
                    'name' => ['required']
                ]
            ],
            'empty2' => [
                [
                    'name' => 'Name'
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
                [
                    'name' => ['required']
                ],
            ],
            'empty4' => [
                [
                    'imageId' => 1,
                    'name'    => 'Name',
                ],
                [
                    'imageId' => 1,
                    'name'    => 'Name',
                    'sort'    => 0,
                ],
            ]
        ];
    }
}
