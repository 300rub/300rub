<?php

namespace ss\tests\unit\models\blocks\helpers\file\_base\AbstractFileModel;

use ss\models\blocks\helpers\file\FileModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFileModel
 */
class AbstractFileModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'originalName' => 'Original_name.jpg',
                    'type'         => 'image/jpeg',
                    'size'         => 1024000,
                    'uniqueName'   => 'akr84ndkro.jpg',
                ],
                [
                    'originalName' => 'Original_name.jpg',
                    'type'         => 'image/jpeg',
                    'size'         => 1024000,
                    'uniqueName'   => 'akr84ndkro.jpg',
                ],
                [
                    'originalName' => 'Original_name_2.jpg',
                    'type'         => 'image/png',
                    'size'         => 2222000,
                    'uniqueName'   => 'aaa84ndkro.png',
                ],
                [
                    'originalName' => 'Original_name_2.jpg',
                    'type'         => 'image/png',
                    'size'         => 2222000,
                    'uniqueName'   => 'aaa84ndkro.png',
                ],
            ]
        ];
    }
}
