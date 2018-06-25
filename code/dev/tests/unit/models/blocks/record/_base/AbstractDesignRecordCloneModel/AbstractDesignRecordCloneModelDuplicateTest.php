<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use ss\models\blocks\record\DesignRecordCloneModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignRecordCloneModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignRecordCloneModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordCloneModel
     */
    protected function getNewModel()
    {
        return new DesignRecordCloneModel();
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
                'containerDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignBlockModel'       => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignTextModel'        => [
                    'size' => 20
                ],
                'dateDesignTextModel'         => [
                    'size' => 20
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 20
                ],
                'viewType'                    => 1,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignBlockModel'       => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignTextModel'        => [
                    'size' => 20
                ],
                'dateDesignTextModel'         => [
                    'size' => 20
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 20
                ],
                'viewType'                    => 1,
            ]
        );
    }
}
