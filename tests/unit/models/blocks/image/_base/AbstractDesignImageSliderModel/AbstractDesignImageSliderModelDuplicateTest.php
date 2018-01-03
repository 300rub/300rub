<?php

namespace testS\tests\unit\models\image\_base\AbstractDesignImageSliderModel;

use testS\models\blocks\image\DesignImageSliderModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignImageSliderModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignImageSliderModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSliderModel
     */
    protected function getNewModel()
    {
        return new DesignImageSliderModel();
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
                'navigationDesignBlockModel'  => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
                'navigationAlignment'         => 1,
                'descriptionAlignment'        => 2,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
                'navigationAlignment'         => 1,
                'descriptionAlignment'        => 2,
            ]
        );
    }
}
