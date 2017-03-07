<?php

namespace testS\tests\unit\models;

use testS\models\BlockModel;
use testS\models\TextModel;

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
        $textModel1 = (new TextModel())->save();
        $textModel2 = (new TextModel())->save();

        return [
            "correct1" => [
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel1->getId(),
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel1->getId(),
                ],
                [
                    "name" => "New Block name",
                ],
                [
                    "name"        => "New Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel1->getId(),
                ]
            ],
            "correct2" => [
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel2->getId(),
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel2->getId(),
                ],
                [
                    "name" => "Updated name",
                ],
                [
                    "name"        => "Updated name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel2->getId(),
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
        $textModel1 = (new TextModel())->save();
        $textModel2 = (new TextModel())->save();
        $textModel3 = (new TextModel())->save();

        return [
            "incorrect1" => [
                [
                    "name"        => "    Block name   ",
                    "language"    => "  1 ",
                    "contentType" => "  1  ",
                    "contentId"   => "  " . $textModel1->getId() . "  ",
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel1->getId(),
                ],
                [
                    "name"        => "   New name   ",
                    "language"    => 2,
                    "contentType" => 2,
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel1->getId(),
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
                    "contentId"   => $textModel2->getId(),
                ],
                [
                    "name"        => "Name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel2->getId(),
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
                    "contentId"   => "  " . $textModel3->getId() . " f",
                ],
                [
                    "name"        => "Block name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel3->getId(),
                ],
                [
                    "name" => "<strong>New name   ",
                ],
                [
                    "name"        => "New name",
                    "language"    => 1,
                    "contentType" => 1,
                    "contentId"   => $textModel3->getId(),
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
        $this->assertSame($modelForCopy->get("name") . " (Copy)", $duplicatedModel->get("name"));
        $this->assertSame($modelForCopy->get("language"), $duplicatedModel->get("language"));
        $this->assertSame($modelForCopy->get("contentType"), $duplicatedModel->get("contentType"));
        $this->assertNotSame($modelForCopy->get("contentId"), $duplicatedModel->get("contentId"));

        $contentModelForCopy = $modelForCopy->getContentModel();
        $duplicatedContentModel = $duplicatedModel->getContentModel();
        $this->assertNotSame($contentModelForCopy->getId(), $duplicatedContentModel->getId());

        $duplicatedModel->delete();
        $this->assertNull(
            $duplicatedContentModel->byId($duplicatedContentModel->getId())->find()
        );
    }
}