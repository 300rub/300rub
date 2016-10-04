<?php

namespace tests\unit\models;

use testS\components\Language;
use models\TextModel;

/**
 * Tests for model TextModel
 *
 * @package tests\unit\models
 */
class TextModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return TextModel
     */
    protected function getModel()
    {
        return new TextModel;
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return [
            // Insert: empty fields
            [
                [],
                [
                    "t.name" => "required",
                ]
            ],
            // Insert: empty values
            [
                [
                    "t.name"            => "",
                    "t.language"        => "",
                    "t.type"            => "",
                    "t.isEditor"       => "",
                    "t.text"            => "",
                    "t.designTextId"  => "",
                    "t.designBlockId" => "",
                ],
                [
                    "t.name" => "required",
                ]
            ],
            // Insert: only name. Update: empty fields
            [
                [
                    "t.name" => "Text test name",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.isEditor" => 0,
                    "t.text"      => ""
                ],
                [],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.isEditor" => 0,
                    "t.text"      => ""
                ],
            ],
            // Insert: only name with HTML tags. Update: empty name
            [
                [
                    "t.name" => "<b>Text</b> <i>test</i> <div>name</div>",
                ],
                [],
                [
                    "t.name" => "Text test name",
                ],
                [
                    "t.name" => "",
                ],
                [
                    "t.name" => "required",
                ],
                [],
            ],
            // Insert: incorrect format parameters. Update with incorrect values
            [
                [
                    "t.name"            => "Text test name",
                    "t.language"        => "incorrect language",
                    "t.type"            => "incorrect type",
                    "t.isEditor"       => "incorrect editor",
                    "t.designTextId"  => "incorrect design text",
                    "t.designBlockId" => "incorrect design block",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.isEditor" => 0,
                    "t.text"      => ""
                ],
                [
                    "t.language"        => 99,
                    "t.type"            => 144,
                    "t.isEditor"       => 34,
                    "t.designTextId"  => 1111,
                    "t.designBlockId" => 3224,
                ],
                [],
                [
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.isEditor" => 1,
                ]
            ],
            // Insert and update with correct parameters
            [
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_EN_ID,
                    "t.type"      => TextModel::TYPE_H1,
                    "t.isEditor" => 1,
                    "t.text"      => "<b>Text</b>",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_EN_ID,
                    "t.type"      => TextModel::TYPE_H1,
                    "t.isEditor" => 1,
                    "t.text"      => "<b>Text</b>",
                ],
                [
                    "t.language"  => Language::LANGUAGE_RU_ID,
                    "t.type"      => TextModel::TYPE_H3,
                    "t.isEditor" => 0,
                    "t.text"      => "<i>New text</i>",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_RU_ID,
                    "t.type"      => TextModel::TYPE_H3,
                    "t.isEditor" => 0,
                    "t.text"      => "<i>New text</i>",
                ]
            ],
            // Insert and update with design parameters
            [
                [
                    "t.name"                      => "Text test name",
                    "designTextModel.size"        => 20,
                    "designTextModel.isItalic"   => 1,
                    "designTextModel.isBold"     => 1,
                    "designBlockModel.marginTop" => 10
                ],
                [],
                [
                    "designTextModel.size"        => 20,
                    "designTextModel.isItalic"   => 1,
                    "designTextModel.isBold"     => 1,
                    "designBlockModel.marginTop" => 10
                ],
                [
                    "designTextModel.size"        => 30,
                    "designTextModel.isItalic"   => 0,
                    "designTextModel.isBold"     => 0,
                    "designBlockModel.marginTop" => 20
                ],
                [],
                [
                    "designTextModel.size"        => 30,
                    "designTextModel.isItalic"   => 0,
                    "designTextModel.isBold"     => 0,
                    "designBlockModel.marginTop" => 20
                ]
            ],
        ];
    }

    /**
     * Duplicate test
     */
    public function testDuplicate()
    {
        $idForCopy = 1;
        $model = $this->getModel()->byId($idForCopy)->find();
        $this->assertNotNull($model);

        $modelAfterDuplicate = $model->duplicate();
        $this->assertNotNull($modelAfterDuplicate);

        $modelForCopy = $this->getModel()->withAll()->byId($idForCopy)->find();
        $modelCopy = $this->getModel()->withAll()->byId($modelAfterDuplicate->id)->find();

        $this->assertNotEquals($modelForCopy->id, $modelCopy->id);
        $this->assertEquals($modelForCopy->isEditor, $modelCopy->isEditor);
        $this->assertEquals($modelForCopy->type, $modelCopy->type);
        $this->assertEquals($modelForCopy->text, $modelCopy->text);
        $this->assertEquals(Language::t("common", "copy") . " {$modelForCopy->name}", $modelCopy->name);
        $this->assertNotEquals($modelForCopy->designTextId, $modelCopy->designTextId);
        $this->assertNotEquals($modelForCopy->designBlockId, $modelCopy->designBlockId);

        foreach ($modelForCopy->designTextModel->getFieldNames() as $field) {
            $this->assertEquals($modelForCopy->designTextModel->$field, $modelCopy->designTextModel->$field);
        }

        foreach ($modelForCopy->designBlockModel->getFieldNames() as $field) {
            $this->assertEquals($modelForCopy->designBlockModel->$field, $modelCopy->designBlockModel->$field);
        }

        $this->assertTrue($modelCopy->delete());
    }
}