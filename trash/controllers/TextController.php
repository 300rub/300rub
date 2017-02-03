<?php
//
//namespace testS\controllers;
//
//use testS\components\Language;
//use testS\models\GridModel;
//use testS\models\TextModel;
//
///**
// * Text's controller
// *
// * @package testS\controllers
// *
// * @method TextModel getModel($width = [], $allowEmpty = false)
// */
//class TextController extends AbstractController
//{
//
//    /**
//     * Gets model name
//     *
//     * @return string
//     */
//    protected function getModelName()
//    {
//        return "TextModel";
//    }
//
//    /**
//     * Gets guest actions
//     *
//     * @return string[]
//     */
//    protected function getGuestActions()
//    {
//        return [];
//    }
//
//    /**
//     * Content
//     */
//    public function actionContent()
//    {
//        $this->json = [
//            "content" => $this->compressHtml(
//                $this->renderPartial("content.text", ["model" => $this->getModel("*")], true)
//            )
//        ];
//    }
//
//    /**
//     * Panel. List of texts
//     */
//    public function actionPanelList()
//    {
//        $list = [];
//        $models = $this->filterList(
//            TextModel::model()->ordered()->findAll(),
//            GridModel::TYPE_TEXT
//        );
//
//        foreach ($models as $model) {
//            $items[] = [
//                "label" => $model->name,
//                "id"    => $model->id
//            ];
//        }
//
//        $this->json = [
//            "back"              => "block.panelList",
//            "content"           => "text.window",
//            "description"       => Language::t("text", "panelDescription"),
//            "design"            => "text.design",
//            "icon"              => "fa-font",
//            "list"              => $list,
//            "settings"          => "text.settings",
//            "title"             => Language::t("text", "texts"),
//            "isDisplayFromPage" => $this->isDisplayFromPage()
//        ];
//    }
//
//    /**
//     * Panel. Setting's forms
//     */
//    public function actionSettings()
//    {
//        $model = $this->getModel([], true);
//
//        $this->json = [
//            "handler"     => "settingsText",
//            "back"        => "text/panelList",
//            "title"       => Language::t("common", "settings"),
//            "description" => Language::t("text", "settingsDescription"),
//            "action"      => "section.saveSettings",
//            "id"          => $model->id,
//            "submit"      => [
//                "label"   => Language::t("common", $model->id ? "save" : "add"),
//                "content" => "text.panelList",
//                "action"  => "text.saveSettings",
//            ]
//        ];
//
//        if ($model->id) {
//            $this->json["update"] = [
//                "selector" => ".text-{$model->id}",
//                "content"  => "text.content"
//            ];
//        }
//
//        $this->setFormsForJson($model, ["name", "type", "isEditor"]);
//    }
//
//    /**
//     * Panel. Saves settings
//     */
//    public function actionSaveSettings()
//    {
//        $this->setCheckboxValue("t.isEditor");
//        $model = $this->getModel([], true);
//        $model->setAttributes($this->data)->save();
//
//        $this->json = [
//            "errors" => $model->errors,
//        ];
//    }
//
//    /**
//     * Panel. Design forms
//     */
//    public function actionDesign()
//    {
//        $model = $this->getModel("*");
//
//        $design = [];
//        $forms = [];
//        if (!$model->isEditor) {
//            $forms[] = [
//                "id"     => $model->designTextModel->id,
//                "type"   => "text",
//                "values" => $model->designTextModel->getValues("designTextModel.%s"),
//            ];
//        }
//        $forms[] = [
//            "id"     => $model->designBlockModel->id,
//            "type"   => "block",
//            "values" => $model->designBlockModel->getValues("designBlockModel.%s"),
//        ];
//        $design[] = [
//            "title" => Language::t("text", "text"),
//            "forms" => $forms
//        ];
//
//        $this->json = [
//            "handler"     => "design",
//            "back"        => "text.panelList",
//            "title"       => Language::t("common", "design"),
//            "description" => Language::t("text", "designDescription"),
//            "id"          => intval($model->id),
//            "design"      => $design,
//            "submit"      => [
//                "content" => "text.panelList",
//                "action"  => "text.saveDesign",
//            ],
//        ];
//    }
//
//    /**
//     * Panel. Saves design
//     */
//    public function actionSaveDesign()
//    {
//        $this->getModel("*")->setAttributes($this->data)->save();
//    }
//
//    /**
//     * Window. Text forms
//     */
//    public function actionWindow()
//    {
//        $model = $this->getModel();
//
//        $this->json = [
//            "title"    => $model->name,
//            "action"   => "text.saveWindow",
//            "handler"  => "text",
//            "id"       => $model->id,
//            "selector" => ".text-{$model->id}",
//            "isEditor" => boolval($model->isEditor)
//        ];
//
//        $this->setFormsForJson($model, ["text"]);
//    }
//
//    /**
//     * Window. Saves text
//     */
//    public function actionSaveWindow()
//    {
//        $this->getModel()->setAttributes($this->data)->save();
//    }
//}