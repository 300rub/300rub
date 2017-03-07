<?php

namespace testS\tests\unit\models;

use testS\models\BlockModel;

/**
 * Tests for the model BlockModel
 *
 * @package testS\tests\unit\models
 */
class BlockModelTest extends AbstractModelTest
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
                self::EXCEPTION_CONTENT
            ],
            "empty2" => [
                [
                    "name"        => "",
                    "language"    => "",
                    "contentType" => "",
                    "contentId"   => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty3" => [
                [
                    "contentType" => 1,
                ],
                [
                    "name" => ["required"]
                ],
            ],
            "empty4" => [
                [
                    "name"        => "Name",
                    "contentType" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty5" => [
                [
                    "contentType" => 0,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
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
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name" => "New Block name",
                ],
                [
                    "name"        => "New Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ]
            ],
            "correct2" => [
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 2,
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 2,
                ],
                [
                    "name" => "Updated name",
                ],
                [
                    "name"        => "Updated name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 2,
                ]
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
                    "name"        => "    Block name   ",
                    "language"    => "  1 ",
                    "contentType" => "  1  ",
                    "contentId"   => "  1  ",
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name"        => "   New name   ",
                    "language"    => 2,
                    "contentType" => 2,
                    "contentId"   => 2,
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ]
            ],
            "incorrect2" => [
                [
                    "name"        => $this->generateStringWithLength("256"),
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name" => ["max"]
                ]
            ],
            "incorrect3" => [
                [
                    "name"        => "Name",
                    "language"    => 999,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name"        => "Name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ]
            ],
            "incorrect4" => [
                [
                    "name"        => "Name",
                    "language"    => 1,
                    "contentType" => 999,
                    "contentId"   => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "incorrect5" => [
                [
                    "name"        => "Name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 999,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect6" => [
                [
                    "name"        => "<b>  Block name   </b>",
                    "language"    => "  1 a",
                    "contentType" => "  1  d",
                    "contentId"   => "  1  f",
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ],
                [
                    "name"        => "<strong>New name   ",
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => 1,
                ]
            ],
        ];
    }
}