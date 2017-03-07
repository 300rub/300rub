<?php

namespace testS\tests\unit\models;

use testS\models\TextInstanceModel;

/**
 * Tests for the model TextInstanceModel
 *
 * @package testS\tests\unit\models
 */
class TextInstanceModelTest extends AbstractModelTest
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
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty2" => [
                [
                    "textId" => "",
                    "text"   => ""
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "textId" => 0,
                    "text"   => ""
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "textId" => 1,
                    "text"   => ""
                ],
                [
                    "textId" => 1,
                    "text" => ""
                ],
            ],
            "empty5" => [
                [
                    "textId" => 1
                ],
                [
                    "textId" => 1,
                    "text" => ""
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        return [
            "correct1" => [
                [
                    "textId" => 1,
                    "text"   => "Some text"
                ],
                [
                    "textId" => 1,
                    "text"   => "Some text"
                ],
                [
                    "text"   => "New text"
                ],
                [
                    "textId" => 1,
                    "text"   => "New text"
                ],
            ],
            "correct2" => [
                [
                    "textId" => 2,
                    "text"   => "<p>Some <b>text</b></p>"
                ],
                [
                    "textId" => 2,
                    "text"   => "<p>Some <b>text</b></p>"
                ],
                [
                    "text"   => "<p><i>Some</i></p>"
                ],
                [
                    "textId" => 2,
                    "text"   => "<p><i>Some</i></p>"
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [
            "incorrect1" => [
                [
                    "textId" => "1",
                    "text"   => 123
                ],
                [
                    "textId" => 1,
                    "text"   => "123"
                ],
                [
                    "textId" => 2,
                    "text"   => "   333   "
                ],
                [
                    "textId" => 1,
                    "text"   => "333"
                ],
            ],
            "incorrect2" => [
                [
                    "textId" => 999,
                    "text"   => "Text"
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect3" => [
                [
                    "textId" => 1,
                    "text"   => "  Text "
                ],
                [
                    "textId" => 1,
                    "text"   => "Text"
                ],
                [
                    "text"   => []
                ],
                [
                    "textId" => 1,
                    "text"   => ""
                ],
            ],
            "incorrect4" => [
                [
                    "textId" => "  1  a",
                    "text"   => new \stdClass()
                ],
                [
                    "textId" => 1,
                    "text"   => ""
                ],
                [
                    "text"   => 1
                ],
                [
                    "textId" => 1,
                    "text"   => "1"
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function getDataProviderDuplicate()
    {
        return [
            "duplicate1" => [
                [
                    "textId" => 1,
                    "text"   => "Some text"
                ],
                [
                    "textId" => 1,
                    "text"   => "Some text"
                ]
            ],
            "duplicate2" => [
                [
                    "textId" => 2,
                    "text"   => "<p>Some <b>text</b></p>"
                ],
                [
                    "textId" => 2,
                    "text"   => "<p>Some <b>text</b></p>"
                ]
            ],
        ];
    }
}