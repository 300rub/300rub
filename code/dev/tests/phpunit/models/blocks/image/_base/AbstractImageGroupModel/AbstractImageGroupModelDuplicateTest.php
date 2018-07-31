<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageGroupModel;

use ss\models\blocks\image\ImageGroupModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'imageId' => 1,
                'seoModel' => [
                    'name' => 'Name'
                ],
                'sort'    => 10,
            ],
            [
                'imageId' => 1,
                'seoModel' => [
                    'name' => 'Name (Copy)'
                ],
                'sort'    => 10,
            ]
        );
    }
}
