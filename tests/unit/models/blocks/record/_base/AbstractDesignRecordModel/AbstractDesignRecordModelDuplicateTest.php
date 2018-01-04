<?php

namespace testS\tests\unit\models\blocks\record\_base\AbstractDesignRecordModel;

use testS\models\blocks\record\DesignRecordModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractDesignRecordModel
 */
class AbstractDesignRecordModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordModel
     */
    protected function getNewModel()
    {
        return new DesignRecordModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            $this->_createData(),
            $this->_createExpectedData()
        );
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _createData()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 20
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 20
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 20
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 20
            ],
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _createExpectedData()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 20
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 20
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 20
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 20
            ],
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1,
        ];
    }
}
