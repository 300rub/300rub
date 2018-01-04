<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use testS\models\blocks\record\DesignRecordCloneModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignRecordCloneModel
 */
class AbstractDesignRecordCloneModelCorrectTest extends AbstractCorrectModelTest
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
            'containerDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'instanceDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'titleDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'titleDesignTextModel'        => [
                'size' => 10
            ],
            'dateDesignTextModel'         => [
                'size' => 10
            ],
            'descriptionDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'descriptionDesignTextModel'  => [
                'size' => 10
            ],
            'viewType'                    => 0,
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
            'containerDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'instanceDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'titleDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'titleDesignTextModel'        => [
                'size' => 10
            ],
            'dateDesignTextModel'         => [
                'size' => 10
            ],
            'descriptionDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'descriptionDesignTextModel'  => [
                'size' => 10
            ],
            'viewType'                    => 0,
        ];
    }
}
