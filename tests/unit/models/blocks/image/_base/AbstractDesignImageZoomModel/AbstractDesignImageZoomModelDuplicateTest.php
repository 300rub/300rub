<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignImageZoomModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignImageZoomModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageZoomModel
     */
    protected function getNewModel()
    {
        return new DesignImageZoomModel();
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
                'designBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'hasScroll'            => true,
                'thumbsAlignment'      => 1,
                'descriptionAlignment' => 2,
                'effect'               => 0,
            ],
            [
                'designBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'hasScroll'            => true,
                'thumbsAlignment'      => 1,
                'descriptionAlignment' => 2,
                'effect'               => 0,
            ]
        );
    }
}
