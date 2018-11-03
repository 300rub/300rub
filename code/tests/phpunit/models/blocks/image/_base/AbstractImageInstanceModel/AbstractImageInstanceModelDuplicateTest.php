<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageInstanceModel;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractImageInstanceModel
 */
class AbstractImageInstanceModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
                'isCover'      => true,
                'sort'         => 10,
                'alt'          => 'Alt 1',
                'width'        => 800,
                'height'       => 600,
                'x1'           => 10,
                'y1'           => 30,
                'x2'           => 70,
                'y2'           => 80,
                'thumbX1'      => 5,
                'thumbY1'      => 15,
                'thumbX2'      => 35,
                'thumbY2'      => 45,
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
            ]
        );
    }
}
