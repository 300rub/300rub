<?php

namespace tests\unit\controllers;

use components\Language;

/**
 * Class SectionControllerTest
 *
 * @package tests\unit\controllers
 */
class SectionControllerTest extends AbstractControllerTest
{

    /**
     * Data provider for testAjaxRequest
     *
     * @return array
     */
    public function dataProviderForAjaxRequest()
    {
        return array_merge(
            $this->_dataProviderForActionPanelList()
        );
    }

    /**
     * Data provider for testAjaxRequest. Tests actionPanelList
     *
     * @return array
     */
    private function _dataProviderForActionPanelList()
    {
        return [
            [
                "section.panelList",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "handler"     => "listSection",
                    "title"       => Language::t("section", "sections"),
                    "description" => Language::t("section", "panelDescription"),
                    "list"        => [
                        [
                            "label" => "Texts",
                            "id"    => 1
                        ]
                    ],
                    "icon"        => "section-list-item",
                    "item"        => [
                        "content" => "section.window",
                        "handler" => "section"
                    ],
                    "design"      => [
                        "content" => "section.design",
                    ],
                    "settings"    => [
                        "content" => "section.settings",
                    ],
                    "add"         => [
                        "label"   => Language::t("common", "add"),
                        "content" => "section.settings",
                    ]
                ]
            ]
        ];
    }
}