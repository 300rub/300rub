<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractBlockModel;

use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

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
