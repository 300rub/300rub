<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use ss\models\blocks\helpers\form\DesignFormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignFormModel
 */
class AbstractDesignFormModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFormModel
     */
    protected function getNewModel()
    {
        return new DesignFormModel();
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
                'containerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'lineDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'labelDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'labelDesignTextModel'      => [
                    'size' => 10
                ],
                'formDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'formDesignTextModel'       => [
                    'size' => 10
                ],
                'submitDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'submitDesignTextModel'     => [
                    'size' => 10
                ],
                'submitIconDesignTextModel' => [
                    'size' => 10
                ],
                'submitIcon'                => 'fa-lock',
                'submitIconPosition'        => 1,
                'submitAlignment'           => 1
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'lineDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'labelDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'labelDesignTextModel'      => [
                    'size' => 10
                ],
                'formDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'formDesignTextModel'       => [
                    'size' => 10
                ],
                'submitDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'submitDesignTextModel'     => [
                    'size' => 10
                ],
                'submitIconDesignTextModel' => [
                    'size' => 10
                ],
                'submitIcon'                => 'fa-lock',
                'submitIconPosition'        => 1,
                'submitAlignment'           => 1
            ]
        );
    }
}
