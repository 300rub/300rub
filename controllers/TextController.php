<?php

namespace controllers;

use components\Language;
use models\TextModel;

/**
 * Text's controller
 *
 * @package controllers
 *
 * @method TextModel getModel($width = [], $allowEmpty = false)
 */
class TextController extends AbstractController
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "TextModel";
    }

    /**
     * Gets guest actions
     *
     * @return string[]
     */
    protected function getGuestActions()
    {
        return [];
    }

    /**
     * Content
     */
    public function actionContent()
    {
        $this->json = [
            "content" => $this->compressHtml(
                $this->renderPartial("content.text", ["model" => $this->getModel("*")], true)
            )
        ];
    }

    /**
     * Panel. List of texts
     */
    public function actionPanelList()
    {
        $list = [];
        $models = TextModel::model()->ordered()->findAll();

        foreach ($models as $model) {
            $items[] = [
                "label" => $model->name,
                "id"    => $model->id
            ];
        }

        $this->json = [
            "back"        => "block.panelList",
            "content"     => "text.window",
            "description" => Language::t("text", "panelDescription"),
            "design"      => "text.design",
            "icon"        => "text",
            "list"        => $list,
            "settings"    => "text.settings",
            "title"       => Language::t("text", "texts"),
        ];
    }

    /**
     * Panel. Setting's forms
     */
    public function actionSettings()
    {
        $model = $this->getModel([], true);

        $this->json = [
            "handler"     => "settingsText",
            "back"        => "text/panelList",
            "title"       => Language::t("common", "settings"),
            "description" => Language::t("text", "settingsDescription"),
            "action"      => "section.saveSettings",
            "id"          => intval($model->id),
            "update"      => [
                "selector" => ".text-",
                "content"  => "text.content"
            ],
            "submit"      => [
                "label"   => Language::t("common", $model->id ? "save" : "add"),
                "content" => "text.panelList",
                "action"  => "text.saveSettings",
            ]
        ];

        $this->setFormsForJson($model, ["t.name", "t.type", "t.is_editor"]);
    }

    /**
     * Panel. Saves settings
     */
    public function actionSaveSettings()
    {
        $this->setCheckboxValue("t.is_editor");
        $model = $this->getModel([], true);
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors" => $model->errors,
        ];
    }

    /**
     * Panel. Design forms
     */
    public function actionDesign()
    {
        $model = $this->getModel("*");

        $design = [];
        $forms = [];
        if (!$model->is_editor) {
            $forms[] = [
                "id"     => $model->designTextModel->id,
                "type"   => "text",
                "values" => $model->designTextModel->getValues("designTextModel.%s"),
            ];
        }
        $forms[] = [
            "id"     => $model->designBlockModel->id,
            "type"   => "block",
            "values" => $model->designBlockModel->getValues("designBlockModel.%s"),
        ];
        $design[] = [
            "title" => Language::t("text", "text"),
            "forms" => $forms
        ];

        $this->json = [
            "handler"     => "design",
            "back"        => "text.panelList",
            "title"       => Language::t("common", "design"),
            "description" => Language::t("text", "designDescription"),
            "id"          => intval($model->id),
            "design"      => $design,
            "submit"      => [
                "content" => "text.panelList",
                "action"  => "text.saveDesign",
            ],
        ];
    }

    /**
     * Panel. Saves design
     */
    public function actionSaveDesign()
    {
        $model = $this->getModel("*");
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors"  => $model->errors,
            "content" => "text.panelList",
        ];
    }

    /**
     * Window. Text forms
     */
    public function actionWindow()
    {
        $model = $this->getModel();

        $this->json = [
            "title"  => $model->name,
            "action" => "section.saveWindow",
            "id"     => intval($model->id),
            "update" => [
                "selector" => ".text-",
                "content"  => "text.content",
            ],
            "isEditor" => boolval($model->is_editor)
        ];

        $this->setFormsForJson($model, ["t.text"]);
    }

    /**
     * Window. Saves text
     */
    public function actionSaveWindow()
    {
        $model = $this->getModel();
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors" => $model->errors,
        ];
    }
}