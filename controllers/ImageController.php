<?php

namespace testS\controllers;

use testS\components\Language;
use testS\models\ImageModel;
use testS\models\GridModel;

/**
 * Image's controller
 *
 * @package controllers
 *
 * @method ImageModel getModel($width = [], $allowEmpty = false)
 */
class ImageController extends AbstractController
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "ImageModel";
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
     * Panel. List of texts
     */
    public function actionPanelList()
    {
        $list = [];
        $models = $this->filterList(
            ImageModel::model()->ordered()->findAll(),
            GridModel::TYPE_IMAGE
        );

        foreach ($models as $model) {
            $items[] = [
                "label" => $model->name,
                "id"    => $model->id
            ];
        }

        $this->json = [
            "back"              => "block.panelList",
            "content"           => "image.window",
            "description"       => Language::t("image", "panelDescription"),
            "design"            => "image.design",
            "icon"              => "fa-picture-o",
            "list"              => $list,
            "settings"          => "image.settings",
            "title"             => Language::t("image", "images"),
            "isDisplayFromPage" => $this->isDisplayFromPage()
        ];
    }
}