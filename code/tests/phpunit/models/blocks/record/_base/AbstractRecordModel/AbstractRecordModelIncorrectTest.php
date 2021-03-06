<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'coverImageModel'     => 'incorrect',
                    'imagesImageModel'    => 'incorrect',
                    'descriptionTextModel' => 'incorrect',
                    'textTextModel'        => 'incorrect',
                    'designRecordModel'   => 'incorrect',
                    'hasCover'          => 'incorrect',
                    'hasImages'         => 'incorrect',
                    'hasCoverZoom'      => 'incorrect',
                    'hasDescription'    => 'incorrect',
                    'useAutoload'       => 'incorrect',
                    'shortCardDateType' => 'incorrect',
                    'fullCardDateType'  => 'incorrect',
                ],
                [
                    'hasCover'             => false,
                    'hasImages'            => false,
                    'hasCoverZoom'         => false,
                    'hasDescription'       => false,
                    'useAutoload'          => false,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                ],
                [
                    'hasCover'             => 999,
                    'hasImages'            => 999,
                    'hasCoverZoom'         => 999,
                    'hasDescription'       => 999,
                    'useAutoload'          => 999,
                    'shortCardDateType'    => 999,
                    'fullCardDateType'     => 999,
                ],
                [
                    'hasCover'             => true,
                    'hasImages'            => true,
                    'hasCoverZoom'         => true,
                    'hasDescription'       => true,
                    'useAutoload'          => true,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                ],
                null,
                null,
                [
                    'designBlockModel',
                    'designImageSliderModel',
                    'designImageZoomModel',
                    'designImageSimpleModel',
                ]
            ]
        ];
    }
}
