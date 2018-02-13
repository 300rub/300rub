<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use ss\models\blocks\helpers\field\DesignFieldModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignFieldModel
 */
class AbstractDesignFieldModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFieldModel
     */
    protected function getNewModel()
    {
        return new DesignFieldModel();
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
                'shortCardContainerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 10
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 10
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 10
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 10
                ],
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 10
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 10
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 10
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 10
                ],
            ]
        );
    }
}
