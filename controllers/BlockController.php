<?php

namespace controllers;

use system\web\Controller;
use system\web\Language;

/**
 * Block's controller
 *
 * @package controllers
 */
class BlockController extends Controller
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
     * Panel. List of block types
     */
    public function actionPanelList()
    {
        $list = [
            [
                "label"   => Language::t("common", "Текст"),
                "content" => "text.panelList",
                "icon"    => "text"
            ]
        ];

        $this->json = [
            "title"       => Language::t("common", "Блоки"),
            "description" => Language::t("common", "Выберите категорию блоков"),
            "list"        => $list,
        ];
    }
}