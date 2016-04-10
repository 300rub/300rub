<?php

namespace controllers;

use components\Language;
use models\GridModel;
use models\SectionModel;

/**
 * Section's controller
 *
 * @package controllers
 *
 * @method SectionModel getModel($width = [], $allowEmpty = false)
 */
class SectionController extends AbstractController
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
            "handler"     => "list",
            "title"       => Language::t("section", "sections"),
            "description" => Language::t("section", "panelDescription"),
            "list"        => $list,
            "icon"        => "section-list-item",
            "item"        => [
                "content" => "section.window",
                "handler" => "section"
            ],
            "design"      => [
                "content" => "section.design",
                "handler" => "section.saveDesign"
            ],
            "settings"    => [
                "content" => "section.settings",
                "handler" => "section.saveSettings"
            ],
            "add"         => [
                "label"   => Language::t("common", "add"),
                "content" => "section.settings",
                "handler" => "section.saveSettings"
            ]
        ];
    }

    /**
     * Panel. Setting's forms
     */
    public function actionSettings()
    {
        $model = $this->getModel(["seoModel"], true);

        $this->json = [
            "handler"     => "settingsSection",
            "back"        => [
                "content" => "section.panelList",
                "handler" => "list"
            ],
            "title"       => Language::t("common", "settings"),
            "description" => Language::t("section", "settingsDescription"),
            "id"          => intval($model->id),
            "submit"      => [
                "label"   => Language::t("common", "save"),
                "content" => "section.panelList",
                "action"  => "section.saveSettings",
                "handler" => "list",
            ]
        ];

        if ($model->id) {
            $this->json["duplicate"] = [
                "action"  => "section.duplicate",
                "content" => "section.settings",
            ];
            $this->json["delete"] = [
                "action"  => "section.delete",
                "content" => "section.panelList",
                "confirm" => Language::t("common", "delete?"),
                "handler" => "list",
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
            "errors"  => $model->errors
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
            "title"       => Language::t("common", "design"),
            "description" => Language::t("section", "designDescription"),
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
            "action" => "section.saveWindow",
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
                $this->data["grid"]
            )
        ];
    }
}