<?php

namespace testS\tests\unit\models;

use testS\models\RecordCloneModel;

/**
 * Tests for the model RecordCloneModel
 *
 * @package testS\tests\unit\models
 */
class RecordCloneModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return RecordCloneModel
     */
    protected function getNewModel()
    {
        return new RecordCloneModel();
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
                    "recordId"               => "",
                    "coverImageModel"       => "",
                    "descriptionTextModel"   => "",
                    "designRecordCloneModel" => "",
                    "hasCover"               => "",
                    "hasCoverZoom"           => "",
                    "hasDescription"         => "",
                    "dateType"               => "",
                    "maxCount"               => ""
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "recordId" => 1,
                ],
                [
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 0,
                        ],
                        "type"             => 0,
                        "useAlbums"        => false,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "viewType"                  => 0,
                    ],
                    "hasCover"               => false,
                    "hasCoverZoom"           => false,
                    "hasDescription"         => false,
                    "dateType"               => 0,
                    "maxCount"               => 0
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
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 10,
                        ],
                        "type"             => 1,
                        "useAlbums"        => true,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "viewType"                  => 1,
                    ],
                    "hasCover"               => true,
                    "hasCoverZoom"           => true,
                    "hasDescription"         => true,
                    "dateType"               => 1,
                    "maxCount"               => 1
                ],
                [
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 10,
                        ],
                        "type"             => 1,
                        "useAlbums"        => true,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "viewType"                  => 1,
                    ],
                    "hasCover"               => true,
                    "hasCoverZoom"           => true,
                    "hasDescription"         => true,
                    "dateType"               => 1,
                    "maxCount"               => 1
                ],
                [
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 20,
                        ],
                        "type"             => 0,
                        "useAlbums"        => false,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 20
                        ],
                        "designBlockModel" => [
                            "marginTop" => 20
                        ],
                        "type"             => 1,
                        "hasEditor"        => false
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "viewType"                  => 1,
                    ],
                    "hasCover"               => false,
                    "hasCoverZoom"           => false,
                    "hasDescription"         => false,
                    "dateType"               => 0,
                    "maxCount"               => 0
                ],
                [
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 20,
                        ],
                        "type"             => 0,
                        "useAlbums"        => false,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 20
                        ],
                        "designBlockModel" => [
                            "marginTop" => 20
                        ],
                        "type"             => 1,
                        "hasEditor"        => false
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "viewType"                  => 1,
                    ],
                    "hasCover"               => false,
                    "hasCoverZoom"           => false,
                    "hasDescription"         => false,
                    "dateType"               => 0,
                    "maxCount"               => 0
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
                    "recordId"               => "incorrect",
                    "coverImageModel"       => "incorrect",
                    "descriptionTextModel"   => "incorrect",
                    "designRecordCloneModel" => "incorrect",
                    "hasCover"               => "incorrect",
                    "hasCoverZoom"           => "incorrect",
                    "hasDescription"         => "incorrect",
                    "dateType"               => "incorrect",
                    "maxCount"               => "incorrect"
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "recordId"               => " 1a ",
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => " 10 s",
                        ],
                        "type"             => "1",
                        "useAlbums"        => 1,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => "10s"
                        ],
                        "designBlockModel" => [
                            "marginTop" => "10d"
                        ],
                        "type"             => "1a",
                        "hasEditor"        => 1
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => "10asd"
                        ],
                        "viewType"                  => "1f",
                    ],
                    "hasCover"               => 1,
                    "hasCoverZoom"           => 1,
                    "hasDescription"         => 1,
                    "dateType"               => true,
                    "maxCount"               => true
                ],
                [
                    "recordId"               => 1,
                    "coverImageModel"       => [
                        "designBlockModel" => [
                            "marginTop" => 10,
                        ],
                        "type"             => 1,
                        "useAlbums"        => true,
                    ],
                    "descriptionTextModel"   => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop" => 10
                        ],
                        "type"             => 1,
                        "hasEditor"        => true
                    ],
                    "designRecordCloneModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "viewType"                  => 1,
                    ],
                    "hasCover"               => true,
                    "hasCoverZoom"           => true,
                    "hasDescription"         => true,
                    "dateType"               => 1,
                    "maxCount"               => 1
                ],
                [
                    "dateType"               => 999,
                ],
                [
                    "dateType"               => 0,
                ]
            ]
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
                "recordId"               => 1,
                "coverImageModel"       => [
                    "designBlockModel" => [
                        "marginTop" => 10,
                    ],
                    "type"             => 1,
                    "useAlbums"        => true,
                ],
                "descriptionTextModel"   => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designRecordCloneModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "viewType"                  => 1,
                ],
                "hasCover"               => true,
                "hasCoverZoom"           => true,
                "hasDescription"         => true,
                "dateType"               => 1,
                "maxCount"               => 1
            ],
            [
                "recordId"               => 1,
                "coverImageModel"       => [
                    "designBlockModel" => [
                        "marginTop" => 10,
                    ],
                    "type"             => 1,
                    "useAlbums"        => true,
                ],
                "descriptionTextModel"   => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                "designRecordCloneModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "viewType"                  => 1,
                ],
                "hasCover"               => true,
                "hasCoverZoom"           => true,
                "hasDescription"         => true,
                "dateType"               => 1,
                "maxCount"               => 1
            ]
        );
    }
}