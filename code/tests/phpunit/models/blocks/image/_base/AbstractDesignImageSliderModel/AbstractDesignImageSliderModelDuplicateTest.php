<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
                'bulletDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
            ]
        );
    }
}
