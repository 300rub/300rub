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
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'viewFileModel'     => [
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => uniqid() . '.jpg',
                ],
                'isCover'           => true,
                'sort'              => 10,
                'alt'               => 'Alt 1',
                'width'             => 800,
                'height'            => 600,
                'viewX'             => 10,
                'viewY'             => 30,
                'viewWidth'         => 70,
                'viewHeight'        => 80,
                'thumbX'            => 5,
                'thumbY'            => 15,
                'thumbWidth'        => 35,
                'thumbHeight'       => 45,
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
            ]
        );
    }
}
