<?php

namespace ss\tests\phpunit\models\blocks\text\_base\AbstractTextInstanceModel;

use ss\models\blocks\text\TextInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model TextInstanceModel
 */
class AbstractTextInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'textId' => '1',
                    'text'   => 123
                ],
                [
                    'textId' => 1,
                    'text'   => '123'
                ],
                [
                    'textId' => 2,
                    'text'   => '   333   '
                ],
                [
                    'textId' => 1,
                    'text'   => '333'
                ],
            ],
            'incorrect2' => [
                [
                    'textId' => 999,
                    'text'   => 'Text'
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'textId' => 1,
                    'text'   => '  Text '
                ],
                [
                    'textId' => 1,
                    'text'   => 'Text'
                ],
                [
                    'text'   => []
                ],
                [
                    'textId' => 1,
                    'text'   => ''
                ],
            ],
            'incorrect4' => [
                [
                    'textId' => '  1  a',
                    'text'   => new \stdClass()
                ],
                [
                    'textId' => 1,
                    'text'   => ''
                ],
                [
                    'text'   => 1
                ],
                [
                    'textId' => 1,
                    'text'   => '1'
                ],
            ],
        ];
    }
}
