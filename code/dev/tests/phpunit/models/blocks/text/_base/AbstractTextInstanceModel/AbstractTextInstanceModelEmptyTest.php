<?php

namespace ss\tests\unit\models\blocks\text\_base\AbstractTextInstanceModel;

use ss\models\blocks\text\TextInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model TextInstanceModel
 */
class AbstractTextInstanceModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'textId' => '',
                    'text'   => ''
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'textId' => 0,
                    'text'   => ''
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'textId' => 1,
                    'text'   => ''
                ],
                [
                    'textId' => 1,
                    'text' => ''
                ],
            ],
            'empty5' => [
                [
                    'textId' => 1
                ],
                [
                    'textId' => 1,
                    'text' => ''
                ],
            ],
        ];
    }
}
