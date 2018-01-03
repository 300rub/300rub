<?php

namespace testS\tests\unit\models\image\_base\AbstractImageGroupModel;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'imageId' => 1,
                    'name'    => 'Name',
                    'sort'    => 10,
                ],
                [
                    'imageId' => 1,
                    'name'    => 'Name',
                    'sort'    => 10,
                ],
                [
                    'name'    => 'Name 2',
                    'sort'    => 20,
                ],
                [
                    'imageId' => 1,
                    'name'    => 'Name 2',
                    'sort'    => 20,
                ],
            ]
        ];
    }
}
