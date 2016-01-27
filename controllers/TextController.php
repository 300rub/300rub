<?php

namespace controllers;

use models\TextModel;
use system\web\Controller;
use system\web\Language;

/**
 * Text's controller
 *
 * @package controllers
 *
 * @method TextModel getModel($width = [], $allowEmpty = false)
 */
class TextController extends Controller
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
            "content" => $this->renderPartial("text.content", ["model" => $this->getModel("*")], true)
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
            "title"       => Language::t("common", "Тексты"),
            "description" => Language::t("common", "Выберите текст для редактирования"),
            "list"        => $list,
            "content"     => "text.window",
            "icon"        => "text",
            "design"      => "text.design",
            "settings"    => "text.settings",
        ];
    }

    /**
     * Panel. Setting's forms
     */
    public function actionSettings()
    {
        $model = $this->getModel([], true);

        $this->json = [
            "back"        => "text/panelList",
            "title"       => Language::t("common", "Настройки текста"),
            "description" => Language::t("common", "333"),
            "action"      => "section.saveSettings",
            "id"          => intval($model->id),
            "update"      => [
                "selector" => ".text-",
                "content"  => "text.content"
            ]
        ];

        $this->setFormsForJson($model, ["t.name", "t.type", "t.is_editor"]);
    }

    /**
     * Panel. Saves settings
     */
    public function actionSaveSettings()
    {
        $model = $this->getModel([], true);
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors"  => $model->errors,
            "content" => "text.panelList",
        ];
    }

    /**
     * Panel. Design forms
     */
    public function actionDesign()
    {
        $model = $this->getModel("*");

        $this->json = [
            "back"        => "text.panelList",
            "title"       => Language::t("common", "Дизайн текстового блока"),
            "description" => Language::t("common", "123"),
            "action"      => "section.saveDesign",
            "id"          => intval($model->id),
            "design"      => $model->getDesignForms()
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
            ]
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