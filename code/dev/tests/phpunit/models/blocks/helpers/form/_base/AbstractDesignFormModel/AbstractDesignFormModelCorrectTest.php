<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use ss\models\blocks\helpers\form\DesignFormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignFormModel
 */
class AbstractDesignFormModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData(),
                $this->_createExpectedData(),
                $this->_updateData(),
                $this->_updateExpectedData(),
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData()
    {
        return [
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
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectedData()
    {
        return [
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
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData()
    {
        return [
            'containerDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'lineDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'labelDesignBlockModel'     => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'labelDesignTextModel'      => [
                'size' => 20
            ],
            'formDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'formDesignTextModel'       => [
                'size' => 20
            ],
            'submitDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'submitDesignTextModel'     => [
                'size' => 20
            ],
            'submitIconDesignTextModel' => [
                'size' => 20
            ],
            'submitIcon'                => 'fa-user',
            'submitIconPosition'        => 2,
            'submitAlignment'           => 2
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectedData()
    {
        return [
            'containerDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'lineDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'labelDesignBlockModel'     => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'labelDesignTextModel'      => [
                'size' => 20
            ],
            'formDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'formDesignTextModel'       => [
                'size' => 20
            ],
            'submitDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'submitDesignTextModel'     => [
                'size' => 20
            ],
            'submitIconDesignTextModel' => [
                'size' => 20
            ],
            'submitIcon'                => 'fa-user',
            'submitIconPosition'        => 2,
            'submitAlignment'           => 2
        ];
    }
}
