<?php

namespace controllers;

use components\Language;
use models\GridLineModel;
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
            "handler"        => "listSection",
            "title"          => Language::t("section", "sections"),
            "description"    => Language::t("section", "panelDescription"),
            "list"           => $list,
            "item"           => "section.window",
            "design"         => "section.design",
            "settings"       => "section.settings",
            "windowCssClass" => "l-window-section",
            "add"            => [
                "label"  => Language::t("section", "addSections"),
                "action" => "section.settings",
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
            "back"        => "section.panelList",
            "title"       => Language::t("common", "settings"),
            "description" => Language::t("section", "settingsDescription"),
            "id"          => intval($model->id),
            "submit"      => [
                "label"   => Language::t("common", $model->id ? "save" : "add"),
                "content" => "section.panelList",
                "action"  => "section.saveSettings",
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
                "confirm" => Language::t("section", "deleteConfirmation"),
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
        $this->setCheckboxValue("t.is_main");
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

        $design = [];
        $design[] = [
            "title" => Language::t("section", "background"),
            "forms" => [
                [
                    "id"     => $model->designBlockModel->id,
                    "type"   => "block",
                    "values" => $model->designBlockModel->getValues("designBlockModel__t.%s")
                ]
            ]
        ];

        $lines = GridLineModel::model()
            ->ordered()
            ->bySectionId($model->id)
            ->with(["outsideDesignModel", "insideDesignModel"])
            ->findAll();
        foreach ($lines as $line) {
            $lineTitle = Language::t("section", "line") . " {$line->sort}";
            $design[] = [
                "title" => $lineTitle,
                "forms" => [
                    [
                        "id"     => $line->outsideDesignModel->id,
                        "type"   => "block",
                        "values" => $line->outsideDesignModel->getValues("lines__{$line->id}__outsideDesignModel.%s"),
                    ]
                ]
            ];
            $design[] = [
                "title" => "{$lineTitle} " . Language::t("section", "container"),
                "forms" => [
                    [
                        "id"     => $line->insideDesignModel->id,
                        "type"   => "block",
                        "values" => $line->insideDesignModel->getValues("lines__{$line->id}__insideDesignModel.%s"),
                    ]
                ]
            ];
        }

        $this->json = [
            "back"        => "section.panelList",
            "title"       => Language::t("common", "design"),
            "handler"     => "design",
            "description" => Language::t("section", "designDescription"),
            "id"          => intval($model->id),
            "submit"      => [
                "content" => "section.panelList",
                "action"  => "section.saveDesign",
            ],
            "design"      => $design
        ];
    }

    /**
     * Panel. Saves design
     */
    public function actionSaveDesign()
    {
        $this->getModel(["designBlockModel"])->saveDesign($this->data);
    }

    /**
     * Window. Grids & blocks structure
     */
    public function actionWindow()
    {
        $model = $this->getModel(["seoModel"]);

        $this->json = [
            "action"  => "section.saveWindow",
            "blocks"  => GridModel::model()->getAllBlocksForGridWindow(),
            "grid"    => GridModel::model()->getAllGridsForGridWindow($model->id),
            "handler" => "section",
            "id"      => intval($model->id),
            "title"   => $model->seoModel->name,
            "button"  => [
                "label" => Language::t("common", "save"),
                "icon" => "fa-check"
            ]
        ];
    }

    /**
     * Window. Saves grids & blocks structure
     */
    public function actionSaveWindow()
    {
        GridModel::model()->updateGridForSection(
            $this->getModel()->id,
            $this->data["grid"]
        );
    }
}