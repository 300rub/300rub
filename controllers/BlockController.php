<?php

namespace controllers;

use components\Language;

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
        $list = [
            [
                "label"   => Language::t("text", "text"),
                "content" => "text.panelList",
                "icon"    => "text-list-group"
            ]
        ];

        $this->json = [
            "handler"     => "listBlock",
            "title"       => Language::t("block", "blocks"),
            "description" => Language::t("block", "selectCategory"),
            "list"        => $list,
            "isParent"    => true
        ];
    }
}