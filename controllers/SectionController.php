<?php

namespace controllers;

use models\GridModel;
use models\SectionModel;
use system\web\Controller;
use system\web\Language;

/**
 * Section's controller
 *
 * @package controllers
 *
 * @method SectionModel getModel($width = [], $allowEmpty = false)
 */
class SectionController extends Controller
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "SectionModel";
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
     * Panel. List of sections
     */
    public function actionPanelList()
    {
        $list = [];
        $models = SectionModel::model()->ordered()->findAll();

        foreach ($models as $model) {
            $item = [
                "label" => $model->seoModel->name,
                "id"    => $model->id
            ];
            if ($model->is_main) {
                $item["icon"] = "main";
            }
            $list[] = $item;
        }

        $this->json = [
            "title"       => Language::t("section", "Sections"),
            "description" => Language::t("section", "Sections panel description"),
            "list"        => $list,
            "content"     => "section.grid",
            "design"      => "section.design",
            "settings"    => "section.settings",
            "add"         => Language::t("common", "Add"),
            "icon"        => "section",
        ];
    }

    /**
     * Panel. Setting's forms
     */
    public function actionSettings()
    {
        $model = $this->getModel(["seoModel"], true);

        $this->json = [
            "back"        => "section.panelList",
            "title"       => Language::t("common", "Настройки раздела"),
            "description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
            "action"      => "section.saveSettings",
            "id"          => intval($model->id)
        ];

        if ($model->id) {
            $this->json["duplicate"] = [
                "action"  => "section.duplicate",
                "content" => "section.settings",
            ];
            $this->json["delete"] = [
                "action"  => "section.delete",
                "confirm" => Language::t("common", "Вы действительно хотите удалить раздел?"),
                "content" => "section.panelList",
            ];
        }

        $forms = [
            "seoModel.name",
            "seoModel.url",
            "t.width",
            "seoModel.title",
            "seoModel.keywords",
            "seoModel.description"
        ];
        if (!$model->is_main) {
            $forms[] = "t.is_main";
        }

        $this->setFormsForJson($model, $forms);
    }

    /**
     * Panel. Saves settings
     */
    public function actionSaveSettings()
    {
        $model = $this->getModel(["seoModel"], true);
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors"  => $model->errors,
            "content" => "section.panelList"
        ];
    }

    /**
     * Panel. Design forms
     */
    public function actionDesign()
    {
        $model = $this->getModel(["designBlockModel"]);

        $this->json = [
            "back"        => "section/panelList",
            "title"       => Language::t("common", "Дизайн раздела"),
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
        $this->json = [
            "result"  => $this->getModel(["designBlockModel"])->saveDesign($this->data),
            "content" => "section/panelList",
        ];
    }

    /**
     * Window. Grids & blocks structure
     */
    public function actionWindow()
    {
        $model = $this->getModel(["seoModel"]);

        $this->json = [
            "title"  => $model->seoModel->name,
            "action" => "section.saveGrid",
            "id"     => intval($model->id),
            "blocks" => GridModel::model()->getAllBlocksForGridWindow(),
            "grid"   => GridModel::model()->getAllGridsForGridWindow($model->id)
        ];
    }

    /**
     * Window. Saves grids & blocks structure
     */
    public function actionSaveWindow()
    {
        $this->json = [
            "result" => GridModel::model()->updateGridForSection(
                $this->getModel()->id,
                $this->data
            )
        ];
    }
}