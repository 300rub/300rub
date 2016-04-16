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
            $this->_dataProviderForActionPanelList(),
            $this->_dataProviderForActionSettings()
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
                    "title"       => "Sections",
                    "description" => "You can add/update/delete sections here",
                    "list"        => [
                        [
                            "label" => "Texts",
                            "id"    => 1,
                            "icon"  => "main"
                        ]
                    ],
                    "icon"        => "section-list-item",
                    "item"        => "section.window",
                    "design"      => "section.design",
                    "settings"    => "section.settings",
                    "add"         => "section.settings",
                ]
            ]
        ];
    }

    /**
     * Data provider for testAjaxRequest. Tests actionSettings
     *
     * @return array
     */
    private function _dataProviderForActionSettings()
    {
        return [
            // Add new section forms
            [
                "section.settings",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "handler"     => "settingsSection",
                    "back"        => "section.panelList",
                    "title"       => "Settings",
                    "description" => "You can edit section's name and SEO",
                    "id"          => 0,
                    "submit"      => [
                        "label"   => "Add",
                        "content" => "section.panelList",
                        "action"  => "section.saveSettings",
                    ],
                    "forms" => [
                        [
                            "name"  => "seoModel.name",
                            "rules" => ["required", "max" => 255],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "seoModel.url",
                            "rules" => ["required", "url", "max" => 255],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "t.width",
                            "rules" => [],
                            "type"  => "field",
                            "value" => 0
                        ],
                        [
                            "name"  => "seoModel.title",
                            "rules" => ["max" => 100],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "seoModel.keywords",
                            "rules" => ["max" => 255],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "seoModel.description",
                            "rules" => ["max" => 255],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "t.is_main",
                            "rules" => [],
                            "type"  => "checkbox",
                            "value" => false
                        ]
                    ]
                ]
            ],
            // For section with ID = 1
            [
                "section.settings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "handler"     => "settingsSection",
                    "back"        => "section.panelList",
                    "title"       => "Settings",
                    "description" => "You can edit section's name and SEO",
                    "id"          => 1,
                    "submit"      => [
                        "label"   => "Save",
                        "content" => "section.panelList",
                        "action"  => "section.saveSettings",
                    ],
                    "duplicate" => [
                        "action"  => "section.duplicate",
                        "content" => "section.settings",
                    ],
                    "delete" => [
                        "action"  => "section.delete",
                        "content" => "section.panelList",
                        "confirm" => "Are you sure that you want to delete the section?",
                    ],
                    "forms" => [
                        [
                            "name"  => "seoModel.name",
                            "rules" => ["required", "max" => 255],
                            "type"  => "field",
                            "value" => "Texts"
                        ],
                        [
                            "name"  => "seoModel.url",
                            "rules" => ["required", "url", "max" => 255],
                            "type"  => "field",
                            "value" => "texts"
                        ],
                        [
                            "name"  => "t.width",
                            "rules" => [],
                            "type"  => "field",
                            "value" => 980
                        ],
                        [
                            "name"  => "seoModel.title",
                            "rules" => ["max" => 100],
                            "type"  => "field",
                            "value" => "Texts page"
                        ],
                        [
                            "name"  => "seoModel.keywords",
                            "rules" => ["max" => 255],
                            "type"  => "field",
                            "value" => "text, texts, blocks"
                        ],
                        [
                            "name"  => "seoModel.description",
                            "rules" => ["max" => 255],
                            "type"  => "field",
                            "value" => "Page for testing text blocks"
                        ]
                    ]
                ]
            ],
            // For section with nonexistent ID
            [
                "section.settings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 9999
                ],
                [
                    "error" => "Model not found"
                ]
            ]
        ];
    }
}