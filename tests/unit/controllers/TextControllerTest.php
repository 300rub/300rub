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
                                                "name"     => "designTextModel.letterSpacing",
                                                "value"    => 0,
                                                "type"     => "letter-spacing",
                                                "minValue" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                                                "measure"  => "px"
                                            ],
                                            [
                                                "name"     => "designTextModel.lineHeight",
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
                                                "name"      => "designTextModel.isItalic",
                                                "value"     => 0,
                                                "type"      => "font-style",
                                                "checked"   => "italic",
                                                "unChecked" => "normal"
                                            ],
                                            [
                                                "name"      => "designTextModel.isBold",
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
                                                    "name"  => "designBlockModel.marginTop",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.marginRight",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.marginBottom",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.marginLeft",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "padding",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.paddingTop",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.paddingRight",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.paddingBottom",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.paddingLeft",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "border-width",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.borderTopWidth",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderRightWidth",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderBottomWidth",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderLeftWidth",
                                                    "value" => 0
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"   => "border-radius",
                                            "values" => [
                                                [
                                                    "name"  => "designBlockModel.borderTopLeftRadius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderTopRightRadius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderBottomRightRadius",
                                                    "value" => 0
                                                ],
                                                [
                                                    "name"  => "designBlockModel.borderBottomLeftRadius",
                                                    "value" => 0
                                                ]
                                            ]
                                        ]
                                    ],
                                    "backgroundColor" => [
                                        "fromName"      => "designBlockModel.backgroundColorFrom",
                                        "fromValue"     => "",
                                        "toName"        => "designBlockModel.backgroundColorTo",
                                        "toValue"       => "",
                                        "gradientName"  => "designBlockModel.gradientDirection",
                                        "gradientValue" => 0
                                    ],
                                    "colors"          => [
                                        [
                                            "type"  => "border-color",
                                            "name"  => "designBlockModel.borderColor",
                                            "value" => ""
                                        ]
                                    ],
                                    "radios"          => [
                                        [
                                            "type"  => "border-style",
                                            "name"  => "designBlockModel.borderStyle",
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
                    "designTextModel.isItalic"                   => "",
                    "designTextModel.isBold"                     => "",
                    "designTextModel.align"                       => "",
                    "designTextModel.decoration"                  => "",
                    "designTextModel.transform"                   => "",
                    "designTextModel.letterSpacing"              => "",
                    "designTextModel.lineHeight"                 => "",
                    // Block
                    "designBlockModel.marginTop"                 => "",
                    "designBlockModel.marginRight"               => "",
                    "designBlockModel.marginBottom"              => "",
                    "designBlockModel.marginLeft"                => "",
                    "designBlockModel.paddingTop"                => "",
                    "designBlockModel.paddingRight"              => "",
                    "designBlockModel.paddingBottom"             => "",
                    "designBlockModel.paddingLeft"               => "",
                    "designBlockModel.backgroundColorFrom"      => "",
                    "designBlockModel.backgroundColorTo"        => "",
                    "designBlockModel.gradientDirection"         => "",
                    "designBlockModel.borderTopWidth"           => "",
                    "designBlockModel.borderTopLeftRadius"     => "",
                    "designBlockModel.borderRightWidth"         => "",
                    "designBlockModel.borderTopRightRadius"    => "",
                    "designBlockModel.borderBottomWidth"        => "",
                    "designBlockModel.borderBottomRightRadius" => "",
                    "designBlockModel.borderLeftWidth"          => "",
                    "designBlockModel.borderBottomLeftRadius"  => "",
                    "designBlockModel.borderColor"               => "",
                    "designBlockModel.borderStyle"               => "",
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
                    "designTextModel.isItalic"                   => 1,
                    "designTextModel.isBold"                     => 1,
                    "designTextModel.align"                       => 2,
                    "designTextModel.decoration"                  => 1,
                    "designTextModel.transform"                   => 1,
                    "designTextModel.letterSpacing"              => 20,
                    "designTextModel.lineHeight"                 => 200,
                    // Block
                    "designBlockModel.marginTop"                 => 10,
                    "designBlockModel.marginRight"               => 10,
                    "designBlockModel.marginBottom"              => 10,
                    "designBlockModel.marginLeft"                => 10,
                    "designBlockModel.paddingTop"                => 10,
                    "designBlockModel.paddingRight"              => 10,
                    "designBlockModel.paddingBottom"             => 10,
                    "designBlockModel.paddingLeft"               => 10,
                    "designBlockModel.backgroundColorFrom"      => "rgba(255,255,255,0.5)",
                    "designBlockModel.backgroundColorTo"        => "rgba(0,255,255,0.5)",
                    "designBlockModel.gradientDirection"         => 1,
                    "designBlockModel.borderTopWidth"           => 20,
                    "designBlockModel.borderTopLeftRadius"     => 20,
                    "designBlockModel.borderRightWidth"         => 20,
                    "designBlockModel.borderTopRightRadius"    => 20,
                    "designBlockModel.borderBottomWidth"        => 20,
                    "designBlockModel.borderBottomRightRadius" => 20,
                    "designBlockModel.borderLeftWidth"          => 20,
                    "designBlockModel.borderBottomLeftRadius"  => 20,
                    "designBlockModel.borderColor"               => 20,
                    "designBlockModel.borderStyle"               => 20,
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
                    "designTextModel.isItalic"                   => "incorrect",
                    "designTextModel.isBold"                     => "incorrect",
                    "designTextModel.align"                       => "incorrect",
                    "designTextModel.decoration"                  => "incorrect",
                    "designTextModel.transform"                   => "incorrect",
                    "designTextModel.letterSpacing"              => "incorrect",
                    "designTextModel.lineHeight"                 => "incorrect",
                    // Block
                    "designBlockModel.marginTop"                 => "incorrect",
                    "designBlockModel.marginRight"               => "incorrect",
                    "designBlockModel.marginBottom"              => "incorrect",
                    "designBlockModel.marginLeft"                => "incorrect",
                    "designBlockModel.paddingTop"                => "incorrect",
                    "designBlockModel.paddingRight"              => "incorrect",
                    "designBlockModel.paddingBottom"             => "incorrect",
                    "designBlockModel.paddingLeft"               => "incorrect",
                    "designBlockModel.backgroundColorFrom"      => "incorrect",
                    "designBlockModel.backgroundColorTo"        => "incorrect",
                    "designBlockModel.gradientDirection"         => "incorrect",
                    "designBlockModel.borderTopWidth"           => "incorrect",
                    "designBlockModel.borderTopLeftRadius"     => "incorrect",
                    "designBlockModel.borderRightWidth"         => "incorrect",
                    "designBlockModel.borderTopRightRadius"    => "incorrect",
                    "designBlockModel.borderBottomWidth"        => "incorrect",
                    "designBlockModel.borderBottomRightRadius" => "incorrect",
                    "designBlockModel.borderLeftWidth"          => "incorrect",
                    "designBlockModel.borderBottomLeftRadius"  => "incorrect",
                    "designBlockModel.borderColor"               => "incorrect",
                    "designBlockModel.borderStyle"               => "incorrect",
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