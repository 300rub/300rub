<?php

namespace testS\tests\unit\models;

use testS\models\TextInstanceModel;
use testS\models\TextModel;

/**
 * Tests for the model TextModel
 *
 * @package testS\tests\unit\models
 */
class TextModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
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
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
            "empty2" => [
                [
                    "designTextModel"  => "",
                    "designBlockModel" => "",
                    "type"             => "",
                    "hasEditor"        => "",
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
            "empty3" => [
                [
                    "designTextId"  => "",
                    "designBlockId" => "",
                    "type"          => "",
                    "hasEditor"     => "",
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
            "empty4" => [
                [
                    "designTextId"  => null,
                    "designBlockId" => null,
                    "type"          => null,
                    "hasEditor"     => null,
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ],
                [
                    "designTextModel"  => "",
                    "designBlockModel" => "",
                    "type"             => "",
                    "hasEditor"        => "",
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
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
                    "type"      => 0,
                    "hasEditor" => true,
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => true
                ],
                [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 20
                    ],
                    "type"             => 1,
                    "hasEditor"        => false
                ],
                [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop" => 20
                    ],
                    "type"             => 1,
                    "hasEditor"        => false
                ]
            ],
            "correct2" => [
                [
                    "type"      => 1,
                    "hasEditor" => false,
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 1,
                    "hasEditor"        => false
                ],
                [
                    "designTextModel"  => [
                        "size" => 100
                    ],
                    "designBlockModel" => [
                        "marginTop" => 2
                    ],
                    "type"             => 0,
                    "hasEditor"        => true
                ],
                [
                    "designTextModel"  => [
                        "size" => 100
                    ],
                    "designBlockModel" => [
                        "marginTop" => 2
                    ],
                    "type"             => 0,
                    "hasEditor"        => true
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
                    "designTextModel"  => "incorrect",
                    "designBlockModel" => "incorrect",
                    "type"             => "incorrect",
                    "hasEditor"        => "incorrect",
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ],
                [
                    "designTextModel"  => new TextModel(),
                    "designBlockModel" => new \stdClass(),
                    "type"             => new \stdClass(),
                    "hasEditor"        => new \stdClass(),
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
            "incorrect2" => [
                [
                    "designTextModel"  => 1,
                    "designBlockModel" => 2,
                    "type"             => 999,
                    "hasEditor"        => 999,
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => true
                ],
                [
                    "designTextModel"  => [],
                    "designBlockModel" => [],
                    "type"             => -1,
                    "hasEditor"        => -1,
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
            "incorrect3" => [
                [
                    "designTextModel"  => [
                        "size" => "30"
                    ],
                    "designBlockModel" => [
                        "marginTop" => "45"
                    ],
                    "type"             => "1",
                    "hasEditor"        => "true",
                ],
                [
                    "designTextModel"  => [
                        "size" => 30
                    ],
                    "designBlockModel" => [
                        "marginTop" => 45
                    ],
                    "type"             => 1,
                    "hasEditor"        => true
                ],
                [
                    "designTextModel"  => [
                        "size" => "   50    "
                    ],
                    "designBlockModel" => [
                        "marginTop" => "   10   "
                    ],
                    "type"             => "incorrect",
                    "hasEditor"        => "  1   ",
                ],
                [
                    "designTextModel"  => [
                        "size" => 50
                    ],
                    "designBlockModel" => [
                        "marginTop" => 10
                    ],
                    "type"             => 0,
                    "hasEditor"        => true
                ]
            ],
            "incorrect4" => [
                [
                    "designTextId"  => 999,
                    "designBlockId" => 999,
                    "type"          => [],
                    "hasEditor"     => [],
                ],
                [
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect5" => [
                [
                    "designTextModel"  => [
                        "size" => "30 aaa"
                    ],
                    "designBlockModel" => [
                        "marginTop" => "45 sss"
                    ],
                    "type"             => "1dd",
                    "hasEditor"        => "1aa",
                ],
                [
                    "designTextModel"  => [
                        "size" => 30
                    ],
                    "designBlockModel" => [
                        "marginTop" => 45
                    ],
                    "type"             => 1,
                    "hasEditor"        => false
                ],
                [
                    "designTextId"  => 999,
                    "designBlockId" => 999,
                    "type"          => [],
                    "hasEditor"     => [],
                ],
                [
                    "designTextModel"  => [
                        "size" => 30
                    ],
                    "designBlockModel" => [
                        "marginTop" => 45
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
                ]
            ],
        ];
    }

    /**
     * Test duplicate
     */
    public function testDuplicate()
    {
        $modelForCopy = $this->getNewModel()->byId(1)->find();
        $duplicatedModel = $modelForCopy->duplicate();

        $this->assertNotSame($modelForCopy->getId(), $duplicatedModel->getId());
        $this->assertNotSame($modelForCopy->get("designTextId"), $duplicatedModel->get("designTextId"));
        $this->assertNotSame($modelForCopy->get("designBlockId"), $duplicatedModel->get("designBlockId"));
        $this->assertSame($modelForCopy->get("type"), $duplicatedModel->get("type"));
        $this->assertSame($modelForCopy->get("hasEditor"), $duplicatedModel->get("hasEditor"));

        $modelInstancesForCopy = (new TextInstanceModel)->byTextId($modelForCopy->getId())->findAll();
        $duplicatedTextInstances = (new TextInstanceModel)->byTextId($duplicatedModel->getId())->findAll();
        $this->assertSame(count($modelInstancesForCopy), count($duplicatedTextInstances));

        foreach ($modelInstancesForCopy as $key => $modelInstanceForCopy) {
            $this->assertSame($modelForCopy->getId(), $modelInstanceForCopy->get("textId"));

            $duplicatedTextInstance = $duplicatedTextInstances[$key];
            $this->assertSame($duplicatedModel->getId(), $duplicatedTextInstance->get("textId"));

            $this->assertSame($modelInstanceForCopy->get("text"), $duplicatedTextInstance->get("text"));
        }

        $duplicatedModel->delete();
        foreach ($duplicatedTextInstances as $duplicatedTextInstance) {
            $this->assertNull(
                (new TextInstanceModel)->byId($duplicatedTextInstance->getId())->find()
            );
        }
    }
}