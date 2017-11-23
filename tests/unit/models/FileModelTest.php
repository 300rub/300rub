<?php

namespace testS\tests\unit\models;

use testS\models\FileModel;

/**
 * Tests for the model FileModel
 *
 * @package testS\tests\unit\models
 */
class FileModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FileModel
     */
    protected function getNewModel()
    {
        return new FileModel();
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
                    "uniqueName" => ["required"]
                ]
            ],
            "empty2" => [
                [
                    "originalName" => "",
                    "type"         => "",
                    "size"         => "",
                    "uniqueName"   => "",
                ],
                [
                    "uniqueName" => ["required"]
                ]
            ],
            "empty3" => [
                [
                    "originalName" => "",
                    "type"         => "",
                    "size"         => "",
                    "uniqueName"   => "akr84ndkro.jpg",
                ],
                [
                    "originalName" => "",
                    "type"         => "",
                    "size"         => 0,
                    "uniqueName"   => "akr84ndkro.jpg",
                ]
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
                    "originalName" => "Original_name.jpg",
                    "type"         => "image/jpeg",
                    "size"         => 1024000,
                    "uniqueName"   => "akr84ndkro.jpg",
                ],
                [
                    "originalName" => "Original_name.jpg",
                    "type"         => "image/jpeg",
                    "size"         => 1024000,
                    "uniqueName"   => "akr84ndkro.jpg",
                ],
                [
                    "originalName" => "Original_name_2.jpg",
                    "type"         => "image/png",
                    "size"         => 2222000,
                    "uniqueName"   => "aaa84ndkro.png",
                ],
                [
                    "originalName" => "Original_name_2.jpg",
                    "type"         => "image/png",
                    "size"         => 2222000,
                    "uniqueName"   => "aaa84ndkro.png",
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
                    "originalName" => $this->generateStringWithLength(256),
                    "type"         => "image/jpeg",
                    "size"         => 1024000,
                    "uniqueName"   => "akr84ndkro.jpg",
                ],
                [
                    "originalName" => ["maxLength"],
                ],
            ],
            "incorrect2" => [
                [
                    "originalName" => "Original_name.jpg",
                    "type"         => $this->generateStringWithLength(51),
                    "size"         => 1024000,
                    "uniqueName"   => "akr84ndkro.jpg",
                ],
                [
                    "type" => ["maxLength"],
                ],
            ],
            "incorrect3" => [
                [
                    "originalName" => "Original_name.jpg",
                    "type"         => "image/jpeg",
                    "size"         => 1024000,
                    "uniqueName"   => $this->generateStringWithLength(26),
                ],
                [
                    "uniqueName" => ["maxLength"],
                ],
            ],
            "incorrect4" => [
                [
                    "originalName" => 111111,
                    "type"         => 2222,
                    "size"         => "1024000",
                    "uniqueName"   => 4124124,
                ],
                [
                    "originalName" => "111111",
                    "type"         => "2222",
                    "size"         => 1024000,
                    "uniqueName"   => "4124124",
                ],
            ],
            "incorrect5" => [
                [
                    "originalName" => "<b>aaa</b>",
                    "type"         => "<b> bbb </b>",
                    "size"         => "1024000 asdasd",
                    "uniqueName"   => "  <b> ccc </b>",
                ],
                [
                    "originalName" => "aaa",
                    "type"         => "bbb",
                    "size"         => 1024000,
                    "uniqueName"   => "ccc",
                ],
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
                "originalName" => "Original_name.jpg",
                "type"         => "image/jpeg",
                "size"         => 1024000,
                "uniqueName"   => "akr84ndkro.jpg",
            ],
            [
                "uniqueName" => ["required"]
            ]
        );
    }
}