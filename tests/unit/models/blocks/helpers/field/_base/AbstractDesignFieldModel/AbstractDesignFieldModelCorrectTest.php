<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use ss\models\blocks\helpers\field\DesignFieldModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignFieldModel
 */
class AbstractDesignFieldModelCorrectTest extends AbstractCorrectModelTest
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
            'shortCardContainerDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardLabelDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardLabelDesignTextModel'      => [
                'size' => 10
            ],
            'shortCardValueDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardValueDesignTextModel'      => [
                'size' => 10
            ],
            'fullCardContainerDesignBlockModel'  => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardLabelDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardLabelDesignTextModel'       => [
                'size' => 10
            ],
            'fullCardValueDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardValueDesignTextModel'       => [
                'size' => 10
            ],
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
            'shortCardContainerDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardLabelDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardLabelDesignTextModel'      => [
                'size' => 10
            ],
            'shortCardValueDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardValueDesignTextModel'      => [
                'size' => 10
            ],
            'fullCardContainerDesignBlockModel'  => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardLabelDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardLabelDesignTextModel'       => [
                'size' => 10
            ],
            'fullCardValueDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardValueDesignTextModel'       => [
                'size' => 10
            ],
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
            'shortCardContainerDesignBlockModel' => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardLabelDesignBlockModel'     => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardLabelDesignTextModel'      => [
                'size' => 30
            ],
            'shortCardValueDesignBlockModel'     => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardValueDesignTextModel'      => [
                'size' => 30
            ],
            'fullCardContainerDesignBlockModel'  => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardLabelDesignBlockModel'      => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardLabelDesignTextModel'       => [
                'size' => 30
            ],
            'fullCardValueDesignBlockModel'      => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardValueDesignTextModel'       => [
                'size' => 30
            ],
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
            'shortCardContainerDesignBlockModel' => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardLabelDesignBlockModel'     => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardLabelDesignTextModel'      => [
                'size' => 30
            ],
            'shortCardValueDesignBlockModel'     => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'shortCardValueDesignTextModel'      => [
                'size' => 30
            ],
            'fullCardContainerDesignBlockModel'  => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardLabelDesignBlockModel'      => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardLabelDesignTextModel'       => [
                'size' => 30
            ],
            'fullCardValueDesignBlockModel'      => [
                'marginTop'                => 20,
                'borderBottomWidth'        => 70,
                'borderColorHover'         => 'rgb(255,255,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
            ],
            'fullCardValueDesignTextModel'       => [
                'size' => 30
            ],
        ];
    }
}
