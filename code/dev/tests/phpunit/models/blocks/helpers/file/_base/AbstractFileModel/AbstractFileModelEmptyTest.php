<?php

namespace ss\tests\unit\models\blocks\helpers\file\_base\AbstractFileModel;

use ss\models\blocks\helpers\file\FileModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFileModel
 */
class AbstractFileModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return FileModel
     */
    protected function getNewModel()
    {
        return new FileModel();
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
                    'uniqueName' => ['required']
                ]
            ],
            'empty2' => [
                [
                    'originalName' => '',
                    'type'         => '',
                    'size'         => '',
                    'uniqueName'   => '',
                ],
                [
                    'uniqueName' => ['required']
                ]
            ],
            'empty3' => [
                [
                    'originalName' => '',
                    'type'         => '',
                    'size'         => '',
                    'uniqueName'   => 'akr84ndkro.jpg',
                ],
                [
                    'originalName' => '',
                    'type'         => '',
                    'size'         => 0,
                    'uniqueName'   => 'akr84ndkro.jpg',
                ]
            ],
        ];
    }
}
