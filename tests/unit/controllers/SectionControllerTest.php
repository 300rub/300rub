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
            $this->_dataProviderForActionSettings(),
            $this->_dataProviderForActionSaveSettings(),
            $this->_dataProviderForActionDesign()
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

    /**
     * Data provider for testAjaxRequest. Tests actionSaveSettings
     *
     * @return array
     */
    private function _dataProviderForActionSaveSettings()
    {
        return [
            // With empty fields
            [
                "section.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "errors" => [
                        "seoModel.name" => "required",
                        "seoModel.url"  => "required"
                    ]
                ]
            ],
            // With empty name
            [
                "section.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "seoModel.url" => "url"
                ],
                [
                    "errors" => [
                        "seoModel.name" => "required",
                    ]
                ]
            ],
            // With long strings
            [
                "section.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "seoModel.name"        => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "seoModel.url"         => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "seoModel.title"       => "string with length more than 100 symbols,
						string with length more than 100 symbols, string with length more than 100 symbols,
						string with length more than 100 symbols",
                    "seoModel.keywords"    => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "seoModel.description" => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                ],
                [
                    "errors" => [
                        "seoModel.name"        => "max",
                        "seoModel.url"         => "max",
                        "seoModel.title"       => "max",
                        "seoModel.keywords"    => "max",
                        "seoModel.description" => "max",
                    ]
                ]
            ],
            // With correct minimal data
            [
                "section.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "seoModel.name" => "section name"
                ],
                [
                    "errors" => []
                ]
            ],
            // With correct all data
            [
                "section.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "seoModel.name"        => "section name",
                    "seoModel.url"         => "section name",
                    "seoModel.title"       => "section name",
                    "seoModel.keywords"    => "section name",
                    "seoModel.description" => "section name",
                    "t.width"              => 1024,
                ],
                [
                    "errors" => []
                ]
            ],
        ];
    }

    /**
     * Data provider for testAjaxRequest. Tests actionDesign
     *
     * @return array
     */
    private function _dataProviderForActionDesign()
    {
        return [
            // Empty data
            [
                "section.design",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Incorrect data
            [
                "section.design",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 9999
                ],
                [
                    "error" => "Model not found"
                ]
            ],
            // For section with ID = 1
            [
                "section.design",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "back"        => "section.panelList",
                    "title"       => "Design",
                    "handler"     => "design",
                    "description" => "You can configure section's design",
                    "action"      => "section.saveDesign",
                    "id"          => 1,
                    "design"      => [
                        [
                            "title" => "Background",
                            "forms" => [
                                [
                                    "id" => "9",
                                    "type" => "block",
                                    "values" => [
                                        "angles" => [
                                            [
                                                "type" => "margin",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel[t.margin_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.margin_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.margin_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.margin_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel[t.padding_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.padding_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.padding_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.padding_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel[t.border_top_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_right_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_bottom_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_left_width]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel[t.border_top_left_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_top_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_bottom_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel[t.border_bottom_left_radius]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "designBlockModel[t.background_color_from]",
                                            "fromValue" => "",
                                            "toName" => "designBlockModel[t.background_color_to]",
                                            "toValue" => "",
                                            "gradientName" => "designBlockModel[t.gradient_direction]",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "designBlockModel[t.border_color]",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "designBlockModel[t.border_style]",
                                                "value" => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Line 1",
                            "forms" => [
                                [
                                    "id" => "10",
                                    "type" => "block",
                                    "values" => [
                                        "angles" => [
                                            [
                                                "type" => "margin",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.margin_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.margin_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.margin_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.margin_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.padding_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.padding_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.padding_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.padding_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_top_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_right_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_bottom_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_left_width]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_top_left_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_top_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_bottom_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][outsideDesignModel.border_bottom_left_radius]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines[1][outsideDesignModel.background_color_from]",
                                            "fromValue" => "",
                                            "toName" => "lines[1][outsideDesignModel.background_color_to]",
                                            "toValue" => "",
                                            "gradientName" => "lines[1][outsideDesignModel.gradient_direction]",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines[1][outsideDesignModel.border_color]",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines[1][outsideDesignModel.border_style]",
                                                "value" => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Line 1 Container",
                            "forms" => [
                                [
                                    "id" => "11",
                                    "type" => "block",
                                    "values" => [
                                        "angles" => [
                                            [
                                                "type" => "margin",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][insideDesignModel.margin_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.margin_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.margin_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.margin_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][insideDesignModel.padding_top]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.padding_right]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.padding_bottom]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.padding_left]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_top_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_right_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_bottom_width]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_left_width]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_top_left_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_top_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_bottom_right_radius]",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines[1][insideDesignModel.border_bottom_left_radius]",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines[1][insideDesignModel.background_color_from]",
                                            "fromValue" => "",
                                            "toName" => "lines[1][insideDesignModel.background_color_to]",
                                            "toValue" => "",
                                            "gradientName" => "lines[1][insideDesignModel.gradient_direction]",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines[1][insideDesignModel.border_color]",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines[1][insideDesignModel.border_style]",
                                                "value" => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
}