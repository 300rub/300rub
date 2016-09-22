<?php

namespace tests\unit\models;

use components\Language;
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
                    "t.is_editor"       => "",
                    "t.text"            => "",
                    "t.design_text_id"  => "",
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
                    "t.is_editor" => 0,
                    "t.text"      => ""
                ],
                [],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.is_editor" => 0,
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
                    "t.is_editor"       => "incorrect editor",
                    "t.design_text_id"  => "incorrect design text",
                    "t.designBlockId" => "incorrect design block",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.is_editor" => 0,
                    "t.text"      => ""
                ],
                [
                    "t.language"        => 99,
                    "t.type"            => 144,
                    "t.is_editor"       => 34,
                    "t.design_text_id"  => 1111,
                    "t.designBlockId" => 3224,
                ],
                [],
                [
                    "t.language"  => Language::$activeId,
                    "t.type"      => TextModel::TYPE_DIV,
                    "t.is_editor" => 1,
                ]
            ],
            // Insert and update with correct parameters
            [
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_EN_ID,
                    "t.type"      => TextModel::TYPE_H1,
                    "t.is_editor" => 1,
                    "t.text"      => "<b>Text</b>",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_EN_ID,
                    "t.type"      => TextModel::TYPE_H1,
                    "t.is_editor" => 1,
                    "t.text"      => "<b>Text</b>",
                ],
                [
                    "t.language"  => Language::LANGUAGE_RU_ID,
                    "t.type"      => TextModel::TYPE_H3,
                    "t.is_editor" => 0,
                    "t.text"      => "<i>New text</i>",
                ],
                [],
                [
                    "t.name"      => "Text test name",
                    "t.language"  => Language::LANGUAGE_RU_ID,
                    "t.type"      => TextModel::TYPE_H3,
                    "t.is_editor" => 0,
                    "t.text"      => "<i>New text</i>",
                ]
            ],
            // Insert and update with design parameters
            [
                [
                    "t.name"                      => "Text test name",
                    "designTextModel.size"        => 20,
                    "designTextModel.is_italic"   => 1,
                    "designTextModel.is_bold"     => 1,
                    "designBlockModel.margin_top" => 10
                ],
                [],
                [
                    "designTextModel.size"        => 20,
                    "designTextModel.is_italic"   => 1,
                    "designTextModel.is_bold"     => 1,
                    "designBlockModel.margin_top" => 10
                ],
                [
                    "designTextModel.size"        => 30,
                    "designTextModel.is_italic"   => 0,
                    "designTextModel.is_bold"     => 0,
                    "designBlockModel.margin_top" => 20
                ],
                [],
                [
                    "designTextModel.size"        => 30,
                    "designTextModel.is_italic"   => 0,
                    "designTextModel.is_bold"     => 0,
                    "designBlockModel.margin_top" => 20
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
        $this->assertEquals($modelForCopy->is_editor, $modelCopy->is_editor);
        $this->assertEquals($modelForCopy->type, $modelCopy->type);
        $this->assertEquals($modelForCopy->text, $modelCopy->text);
        $this->assertEquals(Language::t("common", "copy") . " {$modelForCopy->name}", $modelCopy->name);
        $this->assertNotEquals($modelForCopy->design_text_id, $modelCopy->design_text_id);
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