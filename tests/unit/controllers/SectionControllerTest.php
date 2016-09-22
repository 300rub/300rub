<?php

namespace tests\unit\controllers;

use components\Language;
use models\GridModel;

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
            $this->_dataProviderForActionSaveDesign(),
            $this->_dataProviderForActionWindow(),
            $this->_dataProviderForActionSaveWindow()
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
                            "name"  => "t.isMain",
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
                                                        "name" => "designBlockModel__t.marginTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.marginRight",
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
                                                        "name" => "lines__1__outsideDesignModel.marginTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.marginRight",
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
                                                        "name" => "lines__1__insideDesignModel.marginTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.marginRight",
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
                    "error" => "Incorrect ID"
                ]
            ],
            // Empty fields
            [
                "section.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1,
                    "designBlockModel" => [
                        "t.marginTop"                 => "",
                        "t.marginRight"               => "",
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
                            "outsideDesignModel.marginTop"                 => "",
                            "outsideDesignModel.marginRight"               => "",
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
                            "insideDesignModel.marginTop"                 => "",
                            "insideDesignModel.marginRight"               => "",
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
                    "content" => "section.panelList",
                ]
            ],
            // Correct values
            [
                "section.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1,
                    "designBlockModel" => [
                        "t.marginTop"                 => 10,
                        "t.marginRight"               => 20,
                        "t.margin_bottom"              => 30,
                        "t.margin_left"                => 40,
                        "t.padding_top"                => 50,
                        "t.padding_right"              => 40,
                        "t.padding_bottom"             => 30,
                        "t.padding_left"               => 20,
                        "t.background_color_from"      => 10,
                        "t.background_color_to"        => "rgba(255,255,255,0.5)",
                        "t.gradient_direction"         => 1,
                        "t.border_top_width"           => 10,
                        "t.border_top_left_radius"     => 5,
                        "t.border_right_width"         => 44,
                        "t.border_top_right_radius"    => 23,
                        "t.border_bottom_width"        => 6,
                        "t.border_bottom_right_radius" => 4,
                        "t.border_left_width"          => 7,
                        "t.border_bottom_left_radius"  => 12,
                        "t.border_color"               => "",
                        "t.border_style"               => "",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.marginTop"                 => 10,
                            "outsideDesignModel.marginRight"               => 10,
                            "outsideDesignModel.margin_bottom"              => 10,
                            "outsideDesignModel.margin_left"                => 10,
                            "outsideDesignModel.padding_top"                => 10,
                            "outsideDesignModel.padding_right"              => 10,
                            "outsideDesignModel.padding_bottom"             => 10,
                            "outsideDesignModel.padding_left"               => 10,
                            "outsideDesignModel.background_color_from"      => "rgba(255,255,255,0.5)",
                            "outsideDesignModel.background_color_to"        => "rgba(0,255,255,0.5)",
                            "outsideDesignModel.gradient_direction"         => 1,
                            "outsideDesignModel.border_top_width"           => 20,
                            "outsideDesignModel.border_top_left_radius"     => 20,
                            "outsideDesignModel.border_right_width"         => 20,
                            "outsideDesignModel.border_top_right_radius"    => 20,
                            "outsideDesignModel.border_bottom_width"        => 20,
                            "outsideDesignModel.border_bottom_right_radius" => 20,
                            "outsideDesignModel.border_left_width"          => 20,
                            "outsideDesignModel.border_bottom_left_radius"  => 20,
                            "outsideDesignModel.border_color"               => 20,
                            "outsideDesignModel.border_style"               => 20,
                            // inside
                            "insideDesignModel.marginTop"                 => 30,
                            "insideDesignModel.marginRight"               => 30,
                            "insideDesignModel.margin_bottom"              => 30,
                            "insideDesignModel.margin_left"                => 30,
                            "insideDesignModel.padding_top"                => 30,
                            "insideDesignModel.padding_right"              => 30,
                            "insideDesignModel.padding_bottom"             => 30,
                            "insideDesignModel.padding_left"               => 30,
                            "insideDesignModel.background_color_from"      => "",
                            "insideDesignModel.background_color_to"        => "",
                            "insideDesignModel.gradient_direction"         => 0,
                            "insideDesignModel.border_top_width"           => 10,
                            "insideDesignModel.border_top_left_radius"     => 10,
                            "insideDesignModel.border_right_width"         => 10,
                            "insideDesignModel.border_top_right_radius"    => 10,
                            "insideDesignModel.border_bottom_width"        => 10,
                            "insideDesignModel.border_bottom_right_radius" => 10,
                            "insideDesignModel.border_left_width"          => 10,
                            "insideDesignModel.border_bottom_left_radius"  => 10,
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
            // Incorrect values
            [
                "section.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1,
                    "designBlockModel" => [
                        "t.marginTop"                 => "incorrect",
                        "t.marginRight"               => "incorrect",
                        "t.margin_bottom"              => "incorrect",
                        "t.margin_left"                => "incorrect",
                        "t.padding_top"                => "incorrect",
                        "t.padding_right"              => "incorrect",
                        "t.padding_bottom"             => "incorrect",
                        "t.padding_left"               => "incorrect",
                        "t.background_color_from"      => "incorrect",
                        "t.background_color_to"        => "incorrect",
                        "t.gradient_direction"         => "incorrect",
                        "t.border_top_width"           => "incorrect",
                        "t.border_top_left_radius"     => "incorrect",
                        "t.border_right_width"         => "incorrect",
                        "t.border_top_right_radius"    => "incorrect",
                        "t.border_bottom_width"        => "incorrect",
                        "t.border_bottom_right_radius" => "incorrect",
                        "t.border_left_width"          => "incorrect",
                        "t.border_bottom_left_radius"  => "incorrect",
                        "t.border_color"               => "incorrect",
                        "t.border_style"               => "incorrect",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.marginTop"                 => "incorrect",
                            "outsideDesignModel.marginRight"               => "incorrect",
                            "outsideDesignModel.margin_bottom"              => "incorrect",
                            "outsideDesignModel.margin_left"                => "incorrect",
                            "outsideDesignModel.padding_top"                => "incorrect",
                            "outsideDesignModel.padding_right"              => "incorrect",
                            "outsideDesignModel.padding_bottom"             => "incorrect",
                            "outsideDesignModel.padding_left"               => "incorrect",
                            "outsideDesignModel.background_color_from"      => "incorrect",
                            "outsideDesignModel.background_color_to"        => "incorrect",
                            "outsideDesignModel.gradient_direction"         => "incorrect",
                            "outsideDesignModel.border_top_width"           => "incorrect",
                            "outsideDesignModel.border_top_left_radius"     => "incorrect",
                            "outsideDesignModel.border_right_width"         => "incorrect",
                            "outsideDesignModel.border_top_right_radius"    => "incorrect",
                            "outsideDesignModel.border_bottom_width"        => "incorrect",
                            "outsideDesignModel.border_bottom_right_radius" => "incorrect",
                            "outsideDesignModel.border_left_width"          => "incorrect",
                            "outsideDesignModel.border_bottom_left_radius"  => "incorrect",
                            "outsideDesignModel.border_color"               => "incorrect",
                            "outsideDesignModel.border_style"               => "incorrect",
                            // inside
                            "insideDesignModel.marginTop"                 => "incorrect",
                            "insideDesignModel.marginRight"               => "incorrect",
                            "insideDesignModel.margin_bottom"              => "incorrect",
                            "insideDesignModel.margin_left"                => "incorrect",
                            "insideDesignModel.padding_top"                => "incorrect",
                            "insideDesignModel.padding_right"              => "incorrect",
                            "insideDesignModel.padding_bottom"             => "incorrect",
                            "insideDesignModel.padding_left"               => "incorrect",
                            "insideDesignModel.background_color_from"      => "incorrect",
                            "insideDesignModel.background_color_to"        => "incorrect",
                            "insideDesignModel.gradient_direction"         => "incorrect",
                            "insideDesignModel.border_top_width"           => "incorrect",
                            "insideDesignModel.border_top_left_radius"     => "incorrect",
                            "insideDesignModel.border_right_width"         => "incorrect",
                            "insideDesignModel.border_top_right_radius"    => "incorrect",
                            "insideDesignModel.border_bottom_width"        => "incorrect",
                            "insideDesignModel.border_bottom_right_radius" => "incorrect",
                            "insideDesignModel.border_left_width"          => "incorrect",
                            "insideDesignModel.border_bottom_left_radius"  => "incorrect",
                            "insideDesignModel.border_color"               => "incorrect",
                            "insideDesignModel.border_style"               => "incorrect",
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

    /**
     * Data provider for testAjaxRequest. Tests actionWindow
     *
     * @return array
     */
    private function _dataProviderForActionWindow()
    {
        return [
            // Empty request
            [
                "section.window",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Incorrect ID
            [
                "section.window",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => "sdfsdfs"
                ],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Nonexistent ID
            [
                "section.window",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 9999
                ],
                [
                    "error" => "Model not found"
                ]
            ],
            // Correct
            [
                "section.window",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "action"  => "section.saveWindow",
                    "blocks"  => [
                        [
                            "name"       => "Text",
                            "isDisabled" => true,
                            "type"       => 0,
                            "id"         => 0,
                        ],
                        [
                            "name"       => "Address. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 5,
                        ],
                        [
                            "name"       => "Default. With design",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 7,
                        ],
                        [
                            "name"       => "Default. With editor",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 8,
                        ],
                        [
                            "name"       => "Default. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 1,
                        ],
                        [
                            "name"       => "First level title. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 2,
                        ],
                        [
                            "name"       => "Important text. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 6,
                        ],
                        [
                            "name"       => "Second level title. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 3,
                        ],
                        [
                            "name"       => "Third level title. Without styles",
                            "isDisabled" => false,
                            "type"       => GridModel::TYPE_TEXT,
                            "id"         => 4,
                        ]
                    ],
                    "grid"    => [
                        1 => [
                            "id" => 1,
                            "grids" => [
                                [
                                    "id"    => 1,
                                    "x"     => 3,
                                    "y"     => 0,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Default. Without styles",
                                ],
                                [
                                    "id"    => 2,
                                    "x"     => 3,
                                    "y"     => 1,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "First level title. Without styles",
                                ],
                                [
                                    "id"    => 3,
                                    "x"     => 3,
                                    "y"     => 2,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Second level title. Without styles",
                                ],
                                [
                                    "id"    => 4,
                                    "x"     => 3,
                                    "y"     => 3,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Third level title. Without styles",
                                ],
                                [
                                    "id"    => 5,
                                    "x"     => 3,
                                    "y"     => 4,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Address. Without styles",
                                ],
                                [
                                    "id"    => 6,
                                    "x"     => 3,
                                    "y"     => 5,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Important text. Without styles",
                                ],
                                [
                                    "id"    => 7,
                                    "x"     => 3,
                                    "y"     => 6,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Default. With design",
                                ],
                                [
                                    "id"    => 8,
                                    "x"     => 3,
                                    "y"     => 7,
                                    "width" => 9,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "name"  => "Default. With editor",
                                ]
                            ]
                        ]
                    ],
                    "handler" => "section",
                    "id"      => 1,
                    "title"   => "Texts"
                ]
            ]
        ];
    }

    /**
     * Data provider for testAjaxRequest. Tests actionSaveWindow
     *
     * @return array
     */
    private function _dataProviderForActionSaveWindow()
    {
        return [
            // Empty data
            [
                "section.saveWindow",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Correct with different types of values
            [
                "section.saveWindow",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => "1",
                    "grid" => [
                        [
                            "id" => 1,
                            "items" => [
                                [
                                    "x"     => 0,
                                    "y"     => 0,
                                    "width" => 12,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 1
                                ],
                                [
                                    "x"     => 3,
                                    "y"     => 2,
                                    "width" => 2,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 2
                                ],
                                [
                                    "x"     => 0,
                                    "y"     => 0,
                                    "width" => 0,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 3
                                ],
                                [
                                    "x"     => "",
                                    "y"     => "",
                                    "width" => "",
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 4
                                ],
                                [
                                    "x"     => "incorrect",
                                    "y"     => "incorrect",
                                    "width" => "incorrect",
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 5
                                ]
                            ]
                        ],
                        [
                            "id" => 0,
                            "items" => [
                                [
                                    "x"     => 0,
                                    "y"     => 0,
                                    "width" => 12,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 6
                                ]
                            ]
                        ],
                        [
                            "items" => [
                                [
                                    "x"     => 0,
                                    "y"     => 0,
                                    "width" => 12,
                                    "type"  => GridModel::TYPE_TEXT,
                                    "id"    => 7
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "result" => true
                ]
            ],
        ];
    }
}