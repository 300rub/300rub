<?php

namespace controllers;

use models\TextModel;
use system\web\Controller;
use system\base\Exception;
use system\web\Language;

/**
 * Text's controller
 *
 * @package controllers
 */
class TextController extends Controller
{

    /**
     * Content
     */
    public function actionContent()
    {
        $this->json = [
            "content" => $this->renderPartial("text.content", ["model" => $this->_getModel("*")], true)
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
        $model = $this->_getModel([], true);

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
        $model = $this->_getModel([], true);
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
        $model = $this->_getModel("*");

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
        $model = $this->_getModel("*");
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
        $model = $this->_getModel();

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
        $model = $this->_getModel();
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors" => $model->errors,
        ];
    }

    /**
     * Gets model
     *
     * @param string[] $width      Relations
     * @param bool     $allowEmpty Allows empty ID
     *
     * @return TextModel
     *
     * @throws Exception
     */
    private function _getModel($width = [], $allowEmpty = false)
    {
        if (!$this->id && !$allowEmpty) {
            throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
        }

        if (!$this->id) {
            return new TextModel();
        }

        $model = TextModel::model()->byId($this->id)->with($width)->find();
        if (!$model) {
            throw new Exception(Language::t("default", "Модель не найдена"), 404);
        }

        return $model;
    }
}