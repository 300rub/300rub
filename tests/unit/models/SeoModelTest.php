<?php

namespace testS\tests\unit\models;

use testS\models\SeoModel;
use stdClass;

/**
 * Tests for the model SeoModel
 *
 * @package testS\tests\unit\models
 */
class SeoModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
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
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "empty2" => [
                [
                    "name" => "",
                    "url"  => "",
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "empty3" => [
                [
                    "url" => "Not empty",
                ],
                [
                    "name" => ["required"]
                ]
            ],
            "empty4" => [
                [
                    "name" => "Not empty"
                ],
                [
                    "name"        => "Not empty",
                    "url"         => "not-empty",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ]
            ],
            "empty5" => [
                [
                    "name"        => "     Not empty        ",
                    "url"         => "     Not empty     url     ",
                    "title"       => "         ",
                    "keywords"    => "          ",
                    "description" => "          "
                ],
                [
                    "name"        => "Not empty",
                    "url"         => "not-empty-----url",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ],
                [
                    "name"     => " Not empty 2 ",
                    "url"      => "",
                    "keywords" => "keywords",
                ],
                [
                    "name"        => "Not empty 2",
                    "url"         => "not-empty-2",
                    "title"       => "",
                    "keywords"    => "keywords",
                    "description" => ""
                ],
            ],
            "empty6" => [
                [
                    "name" => "Not empty",
                ],
                [
                    "name" => "Not empty",
                    "url"  => "not-empty",
                ],
                [
                    "name" => "",
                    "url"  => "",
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "empty7" => [
                [
                    "name" => null,
                    "url"  => null,
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
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
                    "name"        => "Name 1",
                    "url"         => "url-1",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
                ],
                [
                    "name"        => "Name 1",
                    "url"         => "url-1",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
                ],
                [
                    "name"        => "Name 2",
                    "url"         => "url-2",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description"
                ],
                [
                    "name"        => "Name 2",
                    "url"         => "url-2",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description"
                ],
            ],
            "correct2" => [
                [
                    "name" => "Name 1",
                ],
                [
                    "name"        => "Name 1",
                    "url"         => "name-1",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
                ],
                [
                    "name"     => "Name 2",
                    "keywords" => "keywords",
                ],
                [
                    "name"        => "Name 2",
                    "url"         => "name-1",
                    "title"       => "",
                    "keywords"    => "keywords",
                    "description" => ""
                ],
            ],
            "correct3" => [
                [
                    "name"        => "Name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description"
                ],
                [
                    "name"        => "Name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description"
                ],
                [
                    "name"        => "Name 2",
                    "url"         => "url-2",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
                ],
                [
                    "name"        => "Name 2",
                    "url"         => "url-2",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
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
                    "name"        => 1,
                    "url"         => 2,
                    "title"       => 3,
                    "keywords"    => 4,
                    "description" => 5
                ],
                [
                    "name"        => "1",
                    "url"         => "2",
                    "title"       => "3",
                    "keywords"    => "4",
                    "description" => "5"
                ],
                [
                    "name"        => 1.5,
                    "url"         => 2.5,
                    "title"       => 3.5,
                    "keywords"    => 4.5,
                    "description" => 5.5
                ],
                [
                    "name"        => "1.5",
                    "url"         => "25",
                    "title"       => "3.5",
                    "keywords"    => "4.5",
                    "description" => "5.5"
                ],
            ],
            "incorrect2" => [
                [
                    "name"        => true,
                    "url"         => true,
                    "title"       => true,
                    "keywords"    => true,
                    "description" => true
                ],
                [
                    "name"        => "1",
                    "url"         => "1",
                    "title"       => "1",
                    "keywords"    => "1",
                    "description" => "1"
                ],
                [
                    "name"        => false,
                    "url"         => false,
                    "title"       => false,
                    "keywords"    => false,
                    "description" => false
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "incorrect3" => [
                [
                    "name"        => [],
                    "url"         => [],
                    "title"       => [],
                    "keywords"    => [],
                    "description" => []
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "incorrect4" => [
                [
                    "name"        => ["name" => "name", "value"],
                    "url"         => ["name" => "name", "value"],
                    "title"       => ["name" => "name", "value"],
                    "keywords"    => ["name" => "name", "value"],
                    "description" => ["name" => "name", "value"],
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "incorrect5" => [
                [
                    "name"        => new stdClass(),
                    "url"         => new stdClass(),
                    "title"       => new stdClass(),
                    "keywords"    => new stdClass(),
                    "description" => new stdClass(),
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "incorrect6" => [
                [
                    "name"        => $this->generateStringWithLength(256),
                    "url"         => $this->generateStringWithLength(256),
                    "title"       => $this->generateStringWithLength(256),
                    "keywords"    => $this->generateStringWithLength(256),
                    "description" => $this->generateStringWithLength(256),
                ],
                [
                    "name"        => ["maxLength"],
                    "url"         => ["maxLength"],
                    "title"       => ["maxLength"],
                    "keywords"    => ["maxLength"],
                    "description" => ["maxLength"],
                ]
            ],
            "incorrect7" => [
                [
                    "name"        => $this->getStringWithTags("Name"),
                    "url"         => $this->getStringWithTags("url 1"),
                    "title"       => $this->getStringWithTags(" Title "),
                    "keywords"    => $this->getStringWithTags(" keywords, keywords "),
                    "description" => $this->getStringWithTags(" description "),
                ],
                [
                    "name"        => "Name",
                    "url"         => "url-1",
                    "title"       => "Title",
                    "keywords"    => "keywords, keywords",
                    "description" => "description",
                ]
            ],
        ];
    }

    /**
     * Test duplicate
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "name"        => "Name",
                "url"         => "url",
                "title"       => "title",
                "keywords"    => "keywords",
                "description" => "description",
            ],
            [
                "name"        => "Name (Copy)",
                "url"         => "url-copy",
                "title"       => "",
                "keywords"    => "",
                "description" => "",
            ]
        );

        $this->duplicate(
            [
                "name" => "Name",
            ],
            [
                "name"        => "Name (Copy)",
                "url"         => "name-copy",
                "title"       => "",
                "keywords"    => "",
                "description" => "",
            ]
        );
    }
}