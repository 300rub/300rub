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
            $this->_dataProviderForActionDesign(),
            $this->_dataProviderForActionSaveDesign()
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
                    "submit"      => [
                        "content" => "section.panelList",
                        "action"  => "section.saveDesign",
                    ],
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
                                                        "name" => "designBlockModel__t.margin_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.margin_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.margin_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.margin_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.padding_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.padding_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.padding_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.padding_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.border_top_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_right_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_bottom_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_left_width",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.border_top_left_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_top_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_bottom_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.border_bottom_left_radius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "designBlockModel__t.background_color_from",
                                            "fromValue" => "",
                                            "toName" => "designBlockModel__t.background_color_to",
                                            "toValue" => "",
                                            "gradientName" => "designBlockModel__t.gradient_direction",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "designBlockModel__t.border_color",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "designBlockModel__t.border_style",
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
                                                        "name" => "lines__1__outsideDesignModel.margin_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.margin_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.margin_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.margin_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.padding_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.padding_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.padding_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.padding_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_top_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_right_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_bottom_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_left_width",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_top_left_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_top_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_bottom_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.border_bottom_left_radius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines__1__outsideDesignModel.background_color_from",
                                            "fromValue" => "",
                                            "toName" => "lines__1__outsideDesignModel.background_color_to",
                                            "toValue" => "",
                                            "gradientName" => "lines__1__outsideDesignModel.gradient_direction",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines__1__outsideDesignModel.border_color",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines__1__outsideDesignModel.border_style",
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
                                                        "name" => "lines__1__insideDesignModel.margin_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.margin_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.margin_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.margin_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.padding_top",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.padding_right",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.padding_bottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.padding_left",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_top_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_right_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_bottom_width",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_left_width",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_top_left_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_top_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_bottom_right_radius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.border_bottom_left_radius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines__1__insideDesignModel.background_color_from",
                                            "fromValue" => "",
                                            "toName" => "lines__1__insideDesignModel.background_color_to",
                                            "toValue" => "",
                                            "gradientName" => "lines__1__insideDesignModel.gradient_direction",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines__1__insideDesignModel.border_color",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines__1__insideDesignModel.border_style",
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

    /**
     * Data provider for testAjaxRequest. Tests actionSaveDesign
     *
     * @return array
     */
    private function _dataProviderForActionSaveDesign()
    {
        return [
            // Empty data
            [
                "section.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => ""
                ]
            ],
            // Empty fields
            [
                "section.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "designBlockModel" => [
                        "t.margin_top"                 => "",
                        "t.margin_right"               => "",
                        "t.margin_bottom"              => "",
                        "t.margin_left"                => "",
                        "t.padding_top"                => "",
                        "t.padding_right"              => "",
                        "t.padding_bottom"             => "",
                        "t.padding_left"               => "",
                        "t.background_color_from"      => "",
                        "t.background_color_to"        => "",
                        "t.gradient_direction"         => "",
                        "t.border_top_width"           => "",
                        "t.border_top_left_radius"     => "",
                        "t.border_right_width"         => "",
                        "t.border_top_right_radius"    => "",
                        "t.border_bottom_width"        => "",
                        "t.border_bottom_right_radius" => "",
                        "t.border_left_width"          => "",
                        "t.border_bottom_left_radius"  => "",
                        "t.border_color"               => "",
                        "t.border_style"               => "",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.margin_top"                 => "",
                            "outsideDesignModel.margin_right"               => "",
                            "outsideDesignModel.margin_bottom"              => "",
                            "outsideDesignModel.margin_left"                => "",
                            "outsideDesignModel.padding_top"                => "",
                            "outsideDesignModel.padding_right"              => "",
                            "outsideDesignModel.padding_bottom"             => "",
                            "outsideDesignModel.padding_left"               => "",
                            "outsideDesignModel.background_color_from"      => "",
                            "outsideDesignModel.background_color_to"        => "",
                            "outsideDesignModel.gradient_direction"         => "",
                            "outsideDesignModel.border_top_width"           => "",
                            "outsideDesignModel.border_top_left_radius"     => "",
                            "outsideDesignModel.border_right_width"         => "",
                            "outsideDesignModel.border_top_right_radius"    => "",
                            "outsideDesignModel.border_bottom_width"        => "",
                            "outsideDesignModel.border_bottom_right_radius" => "",
                            "outsideDesignModel.border_left_width"          => "",
                            "outsideDesignModel.border_bottom_left_radius"  => "",
                            "outsideDesignModel.border_color"               => "",
                            "outsideDesignModel.border_style"               => "",
                            // inside
                            "insideDesignModel.margin_top"                 => "",
                            "insideDesignModel.margin_right"               => "",
                            "insideDesignModel.margin_bottom"              => "",
                            "insideDesignModel.margin_left"                => "",
                            "insideDesignModel.padding_top"                => "",
                            "insideDesignModel.padding_right"              => "",
                            "insideDesignModel.padding_bottom"             => "",
                            "insideDesignModel.padding_left"               => "",
                            "insideDesignModel.background_color_from"      => "",
                            "insideDesignModel.background_color_to"        => "",
                            "insideDesignModel.gradient_direction"         => "",
                            "insideDesignModel.border_top_width"           => "",
                            "insideDesignModel.border_top_left_radius"     => "",
                            "insideDesignModel.border_right_width"         => "",
                            "insideDesignModel.border_top_right_radius"    => "",
                            "insideDesignModel.border_bottom_width"        => "",
                            "insideDesignModel.border_bottom_right_radius" => "",
                            "insideDesignModel.border_left_width"          => "",
                            "insideDesignModel.border_bottom_left_radius"  => "",
                            "insideDesignModel.border_color"               => "",
                            "insideDesignModel.border_style"               => "",
                        ]
                    ]
                ],
                [
                    "result"  => true,
                    "content" => "section/panelList",
                ]
            ],

        ];
    }
}