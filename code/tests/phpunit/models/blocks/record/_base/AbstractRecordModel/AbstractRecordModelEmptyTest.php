<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return RecordModel
     */
    protected function getNewModel()
    {
        return new RecordModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'hasCover'             => false,
                    'hasImages'            => false,
                    'hasCoverZoom'         => false,
                    'hasDescription'       => false,
                    'useAutoload'          => false,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                ],
                [],
                [],
                null,
                null,
                [
                    'designBlockModel',
                    'designImageSliderModel',
                    'designImageZoomModel',
                    'designImageSimpleModel',
                ]
            ],
        ];
    }
}
