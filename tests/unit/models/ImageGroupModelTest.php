<?php

namespace testS\tests\unit\models;

use testS\models\ImageGroupModel;

/**
 * Tests for the model ImageGroupModel
 *
 * @package testS\tests\unit\models
 */
class ImageGroupModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return ImageGroupModel
     */
    protected function getNewModel()
    {
        return new ImageGroupModel();
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
                [
                    "name" => ["required"]
                ]
            ],
            "empty2" => [
                [
                    "name" => "Name"
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "imageId" => "",
                    "name"    => "",
                    "sort"    => "",
                ],
                [
                    "name" => ["required"]
                ],
            ],
            "empty4" => [
                [
                    "imageId" => 1,
                    "name"    => "Name",
                ],
                [
                    "imageId" => 1,
                    "name"    => "Name",
                    "sort"    => 0,
                ],
            ]
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
                    "imageId" => 1,
                    "name"    => "Name",
                    "sort"    => 10,
                ],
                [
                    "imageId" => 1,
                    "name"    => "Name",
                    "sort"    => 10,
                ],
                [
                    "name"    => "Name 2",
                    "sort"    => 20,
                ],
                [
                    "imageId" => 1,
                    "name"    => "Name 2",
                    "sort"    => 20,
                ],
            ]
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
                    "imageId" => "incorrect",
                    "name"    => "incorrect",
                    "sort"    => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "imageId" => "1 asda",
                    "name"    => "<b>incorrect</b>",
                    "sort"    => " 21 asd",
                ],
                [
                    "imageId" => 1,
                    "name"    => "incorrect",
                    "sort"    => 21,
                ],
                [
                    "name"    => $this->generateStringWithLength(256),
                ],
                [
                    "name"    => ["maxLength"],
                ]
            ],
            "incorrect3" => [
                [
                    "imageId" => 999,
                    "name"    => "Name",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "imageId" => 1,
                "name"    => "Name",
                "sort"    => 10,
            ],
            [
                "imageId" => 1,
                "name"    => "Name",
                "sort"    => 10,
            ]
        );
    }
}