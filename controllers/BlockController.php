<?php

namespace controllers;

use components\Language;
use models\GridModel;
use models\ImageModel;
use models\TextModel;

/**
 * Block's controller
 *
 * @package controllers
 */
class BlockController extends AbstractController
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "";
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
     * Panel. List of block types
     */
    public function actionPanelList()
    {
        $list = [];

        $this->setIsDisplayFromPage();
        $isDisplayFromPage = $this->isDisplayFromPage();
        if ($isDisplayFromPage === true) {
            $models = $this->filterList(
                TextModel::model()->findAll(),
                GridModel::TYPE_TEXT
            );
            if (count($models) > 0) {
                $list[] = [
                    "label"   => Language::t("text", "texts"),
                    "content" => "text.panelList",
                    "icon"    => "fa-font"
                ];
            }

//            $models = $this->filterList(
//                ImageModel::model()->findAll(),
//                GridModel::TYPE_IMAGE
//            );
//            if (count($models) > 0) {
//                $list[] = [
//                    "label"   => Language::t("image", "images"),
//                    "content" => "image.panelList",
//                    "icon"    => "fa-picture-o"
//                ];
//            }
        } else {
            $list[] = [
                "label"   => Language::t("text", "texts"),
                "content" => "text.panelList",
                "icon"    => "fa-font"
            ];
            $list[] = [
                "label"   => Language::t("image", "images"),
                "content" => "image.panelList",
                "icon"    => "fa-picture-o"
            ];
        }

        $this->json = [
            "handler"           => "listBlock",
            "title"             => Language::t("block", "blocks"),
            "description"       => Language::t("block", "selectCategory"),
            "list"              => $list,
            "isParent"          => true,
            "isDisplayFromPage" => $isDisplayFromPage
        ];
    }
}