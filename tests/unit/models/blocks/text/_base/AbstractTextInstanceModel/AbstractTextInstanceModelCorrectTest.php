<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextInstanceModel;

use testS\models\blocks\text\TextInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model TextInstanceModel
 */
class AbstractTextInstanceModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TextInstanceModel
     */
    protected function getNewModel()
    {
        return new TextInstanceModel();
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
                [
                    'textId' => 1,
                    'text'   => 'Some text'
                ],
                [
                    'textId' => 1,
                    'text'   => 'Some text'
                ],
                [
                    'text'   => 'New text'
                ],
                [
                    'textId' => 1,
                    'text'   => 'New text'
                ],
            ],
            'correct2' => [
                [
                    'textId' => 2,
                    'text'   => '<p>Some <b>text</b></p>'
                ],
                [
                    'textId' => 2,
                    'text'   => '<p>Some <b>text</b></p>'
                ],
                [
                    'text'   => '<p><i>Some</i></p>'
                ],
                [
                    'textId' => 2,
                    'text'   => '<p><i>Some</i></p>'
                ],
            ],
        ];
    }
}
