<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractDesignMenuModel;

use ss\models\blocks\menu\DesignMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignMenuModel
 */
class AbstractDesignMenuModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignMenuModel
     */
    protected function getNewModel()
    {
        return new DesignMenuModel();
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
            'firstLevelDesignBlockModel'  => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'firstLevelDesignTextModel'   => [
                'size' => 10
            ],
            'secondLevelDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'secondLevelDesignTextModel'  => [
                'size' => 10
            ],
            'lastLevelDesignBlockModel'   => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'lastLevelDesignTextModel'    => [
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
            'containerDesignBlockModel'   => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'firstLevelDesignBlockModel'  => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'firstLevelDesignTextModel'   => [
                'size' => 10
            ],
            'secondLevelDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'secondLevelDesignTextModel'  => [
                'size' => 10
            ],
            'lastLevelDesignBlockModel'   => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'lastLevelDesignTextModel'    => [
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
            'containerDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'firstLevelDesignBlockModel'  => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'firstLevelDesignTextModel'   => [
                'size' => 20
            ],
            'secondLevelDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'secondLevelDesignTextModel'  => [
                'size' => 20
            ],
            'lastLevelDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'lastLevelDesignTextModel'    => [
                'size' => 20
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
            'containerDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'firstLevelDesignBlockModel'  => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'firstLevelDesignTextModel'   => [
                'size' => 20
            ],
            'secondLevelDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'secondLevelDesignTextModel'  => [
                'size' => 20
            ],
            'lastLevelDesignBlockModel'   => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'lastLevelDesignTextModel'    => [
                'size' => 20
            ],
        ];
    }
}
