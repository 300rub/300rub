<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextInstanceModel;

use testS\models\blocks\text\TextInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model TextInstanceModel
 */
class AbstractTextInstanceModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'textId' => 1,
                'text'   => 'Some text'
            ],
            [
                'textId' => 1,
                'text'   => 'Some text'
            ]
        );

        $this->duplicate(
            [
                'textId' => 2,
                'text'   => '<p>Some <b>text</b></p>'
            ],
            [
                'textId' => 2,
                'text'   => '<p>Some <b>text</b></p>'
            ]
        );
    }
}
