<?php

namespace testS\tests\unit\models;

use testS\models\SectionModel;

/**
 * Tests for the model SectionModel
 *
 * @package testS\tests\unit\models
 */
class SectionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SectionModel
     */
    protected function getNewModel()
    {
        return new SectionModel();
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
                    "seoModel" => [
                        "name" => ["required"],
                        "url"  => ["required", "url"]
                    ]
                ]
            ],
            "empty2" => [
                [
                    "seoModel"         => "",
                    "designBlockModel" => "",
                    "language"         => "",
                    "isMain"           => ""
                ],
                [
                    "seoModel" => [
                        "name" => ["required"],
                        "url"  => ["required", "url"]
                    ]
                ]
            ],
            "empty3" => [
                [
                    "seoModel" => [
                        "url" => "url"
                    ],
                ],
                [
                    "seoModel" => [
                        "name" => ["required"],
                    ]
                ]
            ],
            "empty4" => [
                [
                    "seoModel"         => [
                        "name" => "name"
                    ],
                    "designBlockModel" => "",
                    "language"         => "",
                    "isMain"           => ""
                ],
                [
                    "seoModel"         => [
                        "name" => "name",
                        "url"  => "name"
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ]
            ],
            "empty5" => [
                [
                    "seoModel"         => [
                        "name" => "name"
                    ],
                    "designBlockModel" => null,
                    "language"         => null,
                    "isMain"           => null
                ],
                [
                    "seoModel"         => [
                        "name" => "name",
                        "url"  => "name"
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "language"         => 1,
                    "isMain"           => false
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
                    "seoModel"         => [
                        "name"        => "name",
                        "url"         => "url",
                        "title"       => "title",
                        "keywords"    => "keywords",
                        "description" => "description"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 10,
                        "marginBottom" => 20,
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ],
                [
                    "seoModel"         => [
                        "name"        => "name",
                        "url"         => "url",
                        "title"       => "title",
                        "keywords"    => "keywords",
                        "description" => "description"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 10,
                        "marginBottom" => 20,
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ],
                [
                    "seoModel"         => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 30,
                        "marginBottom" => 40,
                    ],
                    "language"         => 2,
                    "isMain"           => false
                ],
                [
                    "seoModel"         => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 30,
                        "marginBottom" => 40,
                    ],
                    "language"         => 2,
                    "isMain"           => false
                ]
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
                    "seoModel" => [
                        "name" => $this->generateStringWithLength(256),
                    ],
                ],
                [
                    "seoModel" => [
                        "name" => ["maxLength"],
                        "url"  => ["maxLength"]
                    ],
                ],
            ],
            "incorrect2" => [
                [
                    "seoModel" => [
                        "name" => "name",
                        "url"  => "url 2"
                    ],
                ],
                [
                    "seoModel"         => [
                        "name" => "name",
                        "url"  => "url-2"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 0,
                        "marginBottom" => 0,
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ],
                [
                    "designBlockModel" => "incorrect",
                    "language"         => "incorrect",
                    "isMain"           => "incorrect",
                ],
                [
                    "seoModel"         => [
                        "name" => "name",
                        "url"  => "url-2"
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 0,
                        "marginBottom" => 0,
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ],
            ],
            "incorrect3" => [
                [
                    "seoModel" => [
                        "name" => "name",
                    ],
                    "language"         => "1111",
                    "isMain"           => "dasdas"
                ],
                [
                    "seoModel"         => [
                        "name" => "name",
                    ],
                    "designBlockModel" => [
                        "marginTop"    => 0,
                        "marginBottom" => 0,
                    ],
                    "language"         => 1,
                    "isMain"           => false
                ],
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
                "seoModel"         => [
                    "name"        => "name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description"
                ],
                "designBlockModel" => [
                    "marginTop"    => 10,
                    "marginBottom" => 20,
                ],
                "language"         => 1,
                "isMain"           => false
            ],
            [
                "seoModel"         => [
                    "name"        => "name (Copy)",
                    "url"         => "url-copy",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => ""
                ],
                "designBlockModel" => [
                    "marginTop"    => 10,
                    "marginBottom" => 20,
                ],
                "language"         => 1,
                "isMain"           => false
            ]
        );
    }

    /**
     * IsMain test
     */
    public function testIsMain()
    {
        $model = $this->getNewModel()->main()->find();
        if ($model === null) {
            $model = $this->getNewModel();
            $model->set(
                [
                    "seoModel"         => [
                        "name"        => "name",
                    ],
                    "isMain"           => true
                ]
            );
            $model->save();
        }

        $model = $this->getNewModel()->main()->find();
        $this->assertNotNull($model);

        $newModel = $this->getNewModel();
        $newModel->set(
            [
                "seoModel"         => [
                    "name"        => "name",
                ],
                "isMain"           => true
            ]
        );
        $newModel->save();

        $this->assertSame(true, $model->get("isMain"));
        $this->assertSame(false, $newModel->get("isMain"));
    }

    public function testSetStructureAndStatic()
    {
        $sectionModel = $this->getNewModel()->byId(1)->withRelations()->find();
       // var_dump(AbstractModel::getCss());
        $sectionModel->setStructureAndStatic();
       // var_dump(AbstractModel::getCss());
    }
}