<?php

namespace controllers;

use models\GridModel;
use models\SectionModel;
use system\web\Controller;
use system\base\Exception;
use system\web\Language;

/**
 * Section's controller
 *
 * @package controllers
 */
class SectionController extends Controller
{

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
        ];
    }

    /**
     * Panel. Settings
     */
    public function actionSettings()
    {
        $model = $this->_getModel(["seoModel"], true);

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
                "id"      => $model->id,
                "content" => "section.settings",
            ];
            $this->json["delete"] = [
                "action"  => "section.delete",
                "id"      => $model->id,
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
        $model = $this->_getModel(["seoModel"], true);
        $model->setAttributes($this->data)->save();

        $this->json = [
            "errors"  => $model->errors,
            "content" => "section.panelList"
        ];
    }

    /**
     * Window. Grids & blocks structure
     *
     * @throws Exception
     */
    public function actionWindow()
    {
        $model = $this->_getModel(["seoModel"]);

        $this->json = [
            "title"  => $model->seoModel->name,
            "action" => "section/saveGrid/{$model->id}",
            "blocks" => GridModel::model()->getAllBlocksForGridWindow(),
            "grid"   => GridModel::model()->getAllGridsForGridWindow($model->id)
        ];
    }

    /**
     * Window. Saves grids & blocks structure
     *
     * @throws Exception
     */
    public function actionSaveWindow()
    {
        $this->json = [
            "result" => GridModel::model()->updateGridForSection(
                $this->_getModel()->id,
                $this->data
            )
        ];
    }

    /**
     * Panel. Deletes section
     */
    public function actionDelete()
    {
        $this->json = ["result" => $this->_getModel("*")->delete()];
    }

    /**
     * Panel. Duplicates section
     */
    public function actionDuplicate()
    {
        $this->json = ["result" => $this->_getModel("*")->duplicate()];
    }

    /**
     * Panel. Design forms
     */
    public function actionDesign()
    {
        $model = $this->_getModel(["designBlockModel"]);

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
            "result"  => $this->_getModel(["designBlockModel"])->saveDesign($this->data),
            "content" => "section/panelList",
        ];
    }

    /**
     * Gets model
     *
     * @param string[] $width      Relations
     * @param bool     $allowEmpty Allows empty ID
     *
     * @return SectionModel
     *
     * @throws Exception
     */
    private function _getModel($width = [], $allowEmpty = false)
    {
        if (!$this->id && !$allowEmpty) {
            throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
        }

        if (!$this->id) {
            return new SectionModel();
        }

        $model = SectionModel::model()->byId($this->id)->with($width)->find();
        if (!$model) {
            throw new Exception(Language::t("default", "Модель не найдена"), 404);
        }

        return $model;
    }
}