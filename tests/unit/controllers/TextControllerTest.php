<?php

namespace tests\unit\controllers;

use components\Language;
use models\DesignTextModel;

/**
 * Class SectionControllerTest
 *
 * @package tests\unit\controllers
 */
class TextControllerTest extends AbstractControllerTest
{

    /**
     * Data provider for testAjaxRequest
     *
     * @return array
     */
    public function dataProviderForAjaxRequest()
    {
        return array_merge(
            $this->_dataProviderForActionContent(),
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
     * Data provider for testAjaxRequest. Tests actionContent
     *
     * @return array
     */
    private function _dataProviderForActionContent()
    {
        return [
            [
                "text.content",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "content" =>
                        '<div class="design-text-1 design-block-1" style="font-weight: normal; line-height: 140%;">' .
                        'Default. Without styles. The quick brown fox jumps over the lazy dog 0123456789.</div>'
                ]
            ]
        ];
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
                "text.panelList",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "back"        => "block.panelList",
                    "content"     => "text.window",
                    "description" => "Just select any block for working with text",
                    "design"      => "text.design",
                    "icon"        => "text",
                    "list"        => [
                        [
                            "label" => "Address. Without styles",
                            "id"    => 5,
                        ],
                        [
                            "label" => "Default. With design",
                            "id"    => 7,
                        ],
                        [
                            "label" => "Default. With editor",
                            "id"    => 8,
                        ],
                        [
                            "label" => "Default. Without styles",
                            "id"    => 1,
                        ],
                        [
                            "label" => "First level title. Without styles",
                            "id"    => 2,
                        ],
                        [
                            "label" => "Important text. Without styles",
                            "id"    => 6,
                        ],
                        [
                            "label" => "Second level title. Without styles",
                            "id"    => 3,
                        ],
                        [
                            "label" => "Third level title. Without styles",
                            "id"    => 4,
                        ]
                    ],
                    "settings"    => "text.settings",
                    "title"       => "Text",
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
            // Add new text
            [
                "text.settings",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "handler"     => "settingsText",
                    "back"        => "text/panelList",
                    "title"       => "Settings",
                    "description" => "You can configure text's settings",
                    "action"      => "section.saveSettings",
                    "id"          => 0,
                    "submit"      => [
                        "label"   => "Add",
                        "content" => "text.panelList",
                        "action"  => "text.saveSettings",
                    ],
                    "forms"       => [
                        [
                            "name"  => "t.name",
                            "rules" => ["required", "max" => 255],
                            "type"  => "field",
                            "value" => ""
                        ],
                        [
                            "name"  => "t.type",
                            "rules" => [],
                            "type"  => "select",
                            "value" => 0
                        ],
                        [
                            "name"  => "t.isEditor",
                            "rules" => [],
                            "type"  => "checkbox",
                            "value" => 0
                        ]
                    ]
                ]
            ],
            // For text with ID = 1
            [
                "text.settings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "handler"     => "settingsText",
                    "back"        => "text/panelList",
                    "title"       => "Settings",
                    "description" => "You can configure text's settings",
                    "action"      => "section.saveSettings",
                    "id"          => 1,
                    "update"      => [
                        "selector" => ".text-1",
                        "content"  => "text.content"
                    ],
                    "submit"      => [
                        "label"   => "Save",
                        "content" => "text.panelList",
                        "action"  => "text.saveSettings",
                    ],
                    "forms"       => [
                        [
                            "name"  => "t.name",
                            "rules" => ["required", "max" => 255],
                            "type"  => "field",
                            "value" => "Default. Without styles"
                        ],
                        [
                            "name"  => "t.type",
                            "rules" => [],
                            "type"  => "select",
                            "value" => 0
                        ],
                        [
                            "name"  => "t.isEditor",
                            "rules" => [],
                            "type"  => "checkbox",
                            "value" => 0
                        ]
                    ]
                ]
            ],
            // For section with nonexistent ID
            [
                "text.settings",
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
                "text.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "errors" => [
                        "t.name" => "required",
                    ]
                ]
            ],
            // With empty name
            [
                "text.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.name" => ""
                ],
                [
                    "errors" => [
                        "t.name" => "required",
                    ]
                ]
            ],
            // With correct minimal data
            [
                "text.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.name" => "New text block"
                ],
                [
                    "errors" => []
                ]
            ],
            // With correct all data
            [
                "text.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.name"      => "New text block",
                    "t.isEditor" => 1,
                    "t.type"      => 2
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
                "text.design",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Incorrect data
            [
                "text.design",
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
                "text.design",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "handler"     => "design",
                    "back"        => "text.panelList",
                    "title"       => "Design",
                    "description" => "You can configure text's design",
                    "id"          => 1,
                    "design"      => [
                        "title" => "Text",
                        "forms" => [
                            [
                                "id"     => "1",
                                "type"   => "text",
                                "values" => [
                                    [
                                        "fontFamily" => [
                                            "name"  => "designTextModel.family",
                                            "value" => 0
                                        ],
                                        "spinners"   => [
                                            [
                                                "name"     => "designTextModel.size",
                                                "value"    => 0,
                                                "type"     => "font-size",
                                                "minValue" => DesignTextModel::MIN_SIZE_VALUE,
                                                "measure"  => "px"
                                            ],
                                            [
                                                "name"     => "designTextModel.letter_spacing",
                                                "value"    => 0,
                                                "type"     => "letter-spacing",
                                                "minValue" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                                                "measure"  => "px"
                                            ],
                                            [
                                                "name"     => "designTextModel.line_height",
                                                "value"    => 0,
                                                "type"     => "line-height",
                                                "minValue" => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
                                                "measure"  => "%"
                                            ]
                                        ],
                                        "colors"     => [
                                            [
                                                "type"  => "color",
                                                "name"  => "designTextModel.color",
                                                "value" => ""
                                            ]
                                        ],
                                        "checkboxes" => [
                                            [
                                                "name"      => "designTextModel.is_italic",
                                                "value"     => 0,
                                                "type"      => "font-style",
                                                "checked"   => "italic",
                                                "unChecked" => "normal"
                                            ],
                                            [
                                                "name"      => "designTextModel.is_bold",
                                                "value"     => 0,
                                                "type"      => "font-weight",
                                                "checked"   => "bold",
                                                "unChecked" => "normal"
                                            ]
                                        ],
                                        "radios"     => [
                                            [
                                                "type"  => "text-align",
                                                "name"  => "designTextModel.align",
                                                "value" => 0
                                            ],
                                            [
                                                "type"  => "text-decoration",
                                                "name"  => "designTextModel.decoration",
                                                "value" => 0
                                            ],
                                            [
                                                "type"  => "text-transform",
                                                "name"  => "designTextModel.transform",
                                                "value" => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                "id"     => "1",
                                "type"   => "block",
                                "values" => [
                                    "angles"          => [
                                        [
                                            "type"   => "margin",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.margin_top",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.margin_right",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.margin_bottom",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.margin_left",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "padding",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.padding_top",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.padding_right",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.padding_bottom",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.padding_left",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "border-width",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.border_top_width",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_right_width",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_bottom_width",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_left_width",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "border-radius",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.border_top_left_radius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_top_right_radius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_bottom_right_radius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.border_bottom_left_radius",
                                                    "value" => 0
                                                ]
                                            ]
                                        ]
                                    ],
                                    "backgroundColor" => [
                                        "fromName"      => "designBlockModel.background_color_from",
                                        "fromValue"     => "",
                                        "toName"        => "designBlockModel.background_color_to",
                                        "toValue"       => "",
                                        "gradientName"  => "designBlockModel.gradient_direction",
                                        "gradientValue" => 0
                                    ],
                                    "colors"          => [
                                        [
                                            "type"  => "border-color",
                                            "name"  => "designBlockModel.border_color",
                                            "value" => ""
                                        ]
                                    ],
                                    "radios"          => [
                                        [
                                            "type"  => "border-style",
                                            "name"  => "designBlockModel.border_style",
                                            "value" => 0
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
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
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Empty fields
            [
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id"                                          => 1,
                    // Text
                    "designTextModel.size"                        => "",
                    "designTextModel.family"                      => "",
                    "designTextModel.color"                       => "",
                    "designTextModel.is_italic"                   => "",
                    "designTextModel.is_bold"                     => "",
                    "designTextModel.align"                       => "",
                    "designTextModel.decoration"                  => "",
                    "designTextModel.transform"                   => "",
                    "designTextModel.letter_spacing"              => "",
                    "designTextModel.line_height"                 => "",
                    // Block
                    "designBlockModel.margin_top"                 => "",
                    "designBlockModel.margin_right"               => "",
                    "designBlockModel.margin_bottom"              => "",
                    "designBlockModel.margin_left"                => "",
                    "designBlockModel.padding_top"                => "",
                    "designBlockModel.padding_right"              => "",
                    "designBlockModel.padding_bottom"             => "",
                    "designBlockModel.padding_left"               => "",
                    "designBlockModel.background_color_from"      => "",
                    "designBlockModel.background_color_to"        => "",
                    "designBlockModel.gradient_direction"         => "",
                    "designBlockModel.border_top_width"           => "",
                    "designBlockModel.border_top_left_radius"     => "",
                    "designBlockModel.border_right_width"         => "",
                    "designBlockModel.border_top_right_radius"    => "",
                    "designBlockModel.border_bottom_width"        => "",
                    "designBlockModel.border_bottom_right_radius" => "",
                    "designBlockModel.border_left_width"          => "",
                    "designBlockModel.border_bottom_left_radius"  => "",
                    "designBlockModel.border_color"               => "",
                    "designBlockModel.border_style"               => "",
                ],
                [
                    "result"  => true,
                    "content" => "text.panelList",
                ]
            ],
            // Correct values
            [
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id"                                          => 1,
                    // Text
                    "designTextModel.size"                        => 20,
                    "designTextModel.family"                      => 3,
                    "designTextModel.color"                       => "rgba(255,255,255,0.5)",
                    "designTextModel.is_italic"                   => 1,
                    "designTextModel.is_bold"                     => 1,
                    "designTextModel.align"                       => 2,
                    "designTextModel.decoration"                  => 1,
                    "designTextModel.transform"                   => 1,
                    "designTextModel.letter_spacing"              => 20,
                    "designTextModel.line_height"                 => 200,
                    // Block
                    "designBlockModel.margin_top"                 => 10,
                    "designBlockModel.margin_right"               => 10,
                    "designBlockModel.margin_bottom"              => 10,
                    "designBlockModel.margin_left"                => 10,
                    "designBlockModel.padding_top"                => 10,
                    "designBlockModel.padding_right"              => 10,
                    "designBlockModel.padding_bottom"             => 10,
                    "designBlockModel.padding_left"               => 10,
                    "designBlockModel.background_color_from"      => "rgba(255,255,255,0.5)",
                    "designBlockModel.background_color_to"        => "rgba(0,255,255,0.5)",
                    "designBlockModel.gradient_direction"         => 1,
                    "designBlockModel.border_top_width"           => 20,
                    "designBlockModel.border_top_left_radius"     => 20,
                    "designBlockModel.border_right_width"         => 20,
                    "designBlockModel.border_top_right_radius"    => 20,
                    "designBlockModel.border_bottom_width"        => 20,
                    "designBlockModel.border_bottom_right_radius" => 20,
                    "designBlockModel.border_left_width"          => 20,
                    "designBlockModel.border_bottom_left_radius"  => 20,
                    "designBlockModel.border_color"               => 20,
                    "designBlockModel.border_style"               => 20,
                ],
                [
                    "result"  => true,
                    "content" => "text.panelList",
                ]
            ],
            // Incorrect values
            [
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id"                                          => 1,
                    // Text
                    "designTextModel.size"                        => "incorrect",
                    "designTextModel.family"                      => "incorrect",
                    "designTextModel.color"                       => "incorrect",
                    "designTextModel.is_italic"                   => "incorrect",
                    "designTextModel.is_bold"                     => "incorrect",
                    "designTextModel.align"                       => "incorrect",
                    "designTextModel.decoration"                  => "incorrect",
                    "designTextModel.transform"                   => "incorrect",
                    "designTextModel.letter_spacing"              => "incorrect",
                    "designTextModel.line_height"                 => "incorrect",
                    // Block
                    "designBlockModel.margin_top"                 => "incorrect",
                    "designBlockModel.margin_right"               => "incorrect",
                    "designBlockModel.margin_bottom"              => "incorrect",
                    "designBlockModel.margin_left"                => "incorrect",
                    "designBlockModel.padding_top"                => "incorrect",
                    "designBlockModel.padding_right"              => "incorrect",
                    "designBlockModel.padding_bottom"             => "incorrect",
                    "designBlockModel.padding_left"               => "incorrect",
                    "designBlockModel.background_color_from"      => "incorrect",
                    "designBlockModel.background_color_to"        => "incorrect",
                    "designBlockModel.gradient_direction"         => "incorrect",
                    "designBlockModel.border_top_width"           => "incorrect",
                    "designBlockModel.border_top_left_radius"     => "incorrect",
                    "designBlockModel.border_right_width"         => "incorrect",
                    "designBlockModel.border_top_right_radius"    => "incorrect",
                    "designBlockModel.border_bottom_width"        => "incorrect",
                    "designBlockModel.border_bottom_right_radius" => "incorrect",
                    "designBlockModel.border_left_width"          => "incorrect",
                    "designBlockModel.border_bottom_left_radius"  => "incorrect",
                    "designBlockModel.border_color"               => "incorrect",
                    "designBlockModel.border_style"               => "incorrect",
                ],
                [
                    "result"  => true,
                    "content" => "text.panelList",
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
                "text.window",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Incorrect ID
            [
                "text.window",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => "incorrect"
                ],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Nonexistent ID
            [
                "text.window",
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
                "text.window",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1
                ],
                [
                    "title"    => "Default. Without styles",
                    "action"   => "text.saveWindow",
                    "id"       => 1,
                    "selector" => ".text-1",
                    "isEditor" => false,
                    "forms"    => [
                        [
                            "name"  => "t.text",
                            "rules" => [],
                            "type"  => "field",
                            "value" =>
                                "Default. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
                        ]
                    ]
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
                "text.saveWindow",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect ID"
                ]
            ],
            // Correct with different types of values
            [
                "text.saveWindow",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id"     => "1",
                    "t.text" => "new text example"
                ],
                [
                    "errors" => [],
                ]
            ],
        ];
    }
}