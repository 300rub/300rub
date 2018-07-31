<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractBlockModel;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return BlockModel
     */
    protected function getNewModel()
    {
        return new BlockModel();
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        $textModel1 = TextModel::model()->save();
        $textModel2 = TextModel::model()->save();

        return [
            'correct1' => [
                [
                    'name'        => 'Block name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel1->getId(),
                ],
                [
                    'name'        => 'Block name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel1->getId(),
                ],
                [
                    'name' => 'New Block name',
                ],
                [
                    'name'        => 'New Block name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel1->getId(),
                ]
            ],
            'correct2' => [
                [
                    'name'        => 'New name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel2->getId(),
                ],
                [
                    'name'        => 'New name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel2->getId(),
                ],
                [
                    'name' => 'Updated name',
                ],
                [
                    'name'        => 'Updated name',
                    'language'    => 1,
                    'contentType' => 1,
                    'contentId'   => $textModel2->getId(),
                ]
            ],
        ];
    }
}
