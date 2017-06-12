<?php

namespace testS\tests\unit\models;

use testS\models\TabGroupModel;
use testS\models\TabInstanceModel;
use testS\models\TabModel;

/**
 * Tests for the model TabInstanceModel
 *
 * @package testS\tests\unit\models
 */
class TabInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabInstanceModel
     */
    protected function getNewModel()
    {
        return new TabInstanceModel();
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
                    "tabGroupId"     => "",
                    "textInstanceId" => "",
                    "tabTemplateId"  => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "tabGroupId"     => null,
                    "textInstanceId" => null,
                    "tabTemplateId"  => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "tabGroupId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty5" => [
                [
                    "tabTemplateId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "tabGroupId"    => 1,
                    "tabTemplateId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty7" => [
                [
                    "tabGroupId"        => 1,
                    "tabTemplateId"     => 1,
                    "textInstanceModel" => [
                        "textId" => "",
                        "text"   => "",
                    ],
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
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
        $tabId = (new TabGroupModel())->byId(1)->find()->get("tabId");
        $tabModel = (new TabModel)->byId($tabId)->find();
        $textId = $tabModel->get("textId");

        return [
            "correct1" => [
                [
                    "tabGroupId"        => 1,
                    "textInstanceModel" => [
                        "textId" => $textId,
                        "text"   => "text..."
                    ],
                    "tabTemplateId"     => 1,
                ],
                [
                    "tabGroupId"        => 1,
                    "textInstanceModel" => [
                        "textId" => $textId,
                        "text"   => "text..."
                    ],
                    "tabTemplateId"     => 1,
                ],
                [
                    "textInstanceModel" => [
                        "text" => "new text"
                    ],
                ],
                [
                    "tabGroupId"        => 1,
                    "textInstanceModel" => [
                        "textId" => $textId,
                        "text"   => "new text"
                    ],
                    "tabTemplateId"     => 1,
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
        $tabId = (new TabGroupModel())->byId(1)->find()->get("tabId");
        $tabModel = (new TabModel)->byId($tabId)->find();
        $textId = $tabModel->get("textId");

        return [
            "incorrect1" => [
                [
                    "tabGroupId"     => "incorrect",
                    "textInstanceId" => "incorrect",
                    "tabTemplateId"  => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "tabGroupId"     => 999,
                    "textInstanceId" => 999,
                    "tabTemplateId"  => 999,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect3" => [
                [
                    "tabGroupId"     => -1,
                    "textInstanceId" => -1,
                    "tabTemplateId"  => -1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect4" => [
                [
                    "tabGroupId"     => "1",
                    "textInstanceModel" => [
                        "textId" => "incorrect",
                        "text" => ""
                    ],
                    "tabTemplateId"  => " 1 ",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect5" => [
                [
                    "tabGroupId"     => "1",
                    "textInstanceModel" => [
                        "textId" => $textId,
                    ],
                    "tabTemplateId"  => " 1 ",
                ],
                [
                    "tabGroupId"        => 1,
                    "textInstanceModel" => [
                        "textId" => $textId,
                        "text"   => ""
                    ],
                    "tabTemplateId"     => 1,
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
        $tabId = (new TabGroupModel())->byId(1)->find()->get("tabId");
        $tabModel = (new TabModel)->byId($tabId)->find();
        $textId = $tabModel->get("textId");

        $this->duplicate(
            [
                "tabGroupId"        => 1,
                "textInstanceModel" => [
                    "textId" => $textId,
                    "text"   => "text..."
                ],
                "tabTemplateId"     => 1,
            ],
            [
                "tabGroupId"        => 1,
                "textInstanceModel" => [
                    "textId" => $textId,
                    "text"   => "text..."
                ],
                "tabTemplateId"     => 1,
            ]
        );
    }
}