<?php

namespace tests\unit\controllers;

use testS\components\Language;
use testS\models\GridModel;

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
                                                        "name" => "designBlockModel__t.marginBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.marginLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.paddingTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.paddingRight",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.paddingBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.paddingLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.borderTopWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderRightWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderBottomWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderLeftWidth",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "designBlockModel__t.borderTopLeftRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderTopRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderBottomRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "designBlockModel__t.borderBottomLeftRadius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "designBlockModel__t.backgroundColorFrom",
                                            "fromValue" => "",
                                            "toName" => "designBlockModel__t.backgroundColorTo",
                                            "toValue" => "",
                                            "gradientName" => "designBlockModel__t.gradientDirection",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "designBlockModel__t.borderColor",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "designBlockModel__t.borderStyle",
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
                                                        "name" => "lines__1__outsideDesignModel.marginBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.marginLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.paddingTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.paddingRight",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.paddingBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.paddingLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderTopWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderRightWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderBottomWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderLeftWidth",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderTopLeftRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderTopRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderBottomRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__outsideDesignModel.borderBottomLeftRadius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines__1__outsideDesignModel.backgroundColorFrom",
                                            "fromValue" => "",
                                            "toName" => "lines__1__outsideDesignModel.backgroundColorTo",
                                            "toValue" => "",
                                            "gradientName" => "lines__1__outsideDesignModel.gradientDirection",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines__1__outsideDesignModel.borderColor",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines__1__outsideDesignModel.borderStyle",
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
                                                        "name" => "lines__1__insideDesignModel.marginBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.marginLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "padding",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.paddingTop",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.paddingRight",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.paddingBottom",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.paddingLeft",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-width",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderTopWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderRightWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderBottomWidth",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderLeftWidth",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ],
                                            [
                                                "type" => "border-radius",
                                                "values" => [
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderTopLeftRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderTopRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderBottomRightRadius",
                                                        "value" => 0
                                                    ],
                                                    [
                                                        "name" => "lines__1__insideDesignModel.borderBottomLeftRadius",
                                                        "value" => 0
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "backgroundColor" => [
                                            "fromName" => "lines__1__insideDesignModel.backgroundColorFrom",
                                            "fromValue" => "",
                                            "toName" => "lines__1__insideDesignModel.backgroundColorTo",
                                            "toValue" => "",
                                            "gradientName" => "lines__1__insideDesignModel.gradientDirection",
                                            "gradientValue" => 0
                                        ],
                                        "colors" => [
                                            [
                                                "type" => "border-color",
                                                "name" => "lines__1__insideDesignModel.borderColor",
                                                "value" => ""
                                            ]
                                        ],
                                        "radios" => [
                                            [
                                                "type" => "border-style",
                                                "name" => "lines__1__insideDesignModel.borderStyle",
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
                        "t.marginBottom"              => "",
                        "t.marginLeft"                => "",
                        "t.paddingTop"                => "",
                        "t.paddingRight"              => "",
                        "t.paddingBottom"             => "",
                        "t.paddingLeft"               => "",
                        "t.backgroundColorFrom"      => "",
                        "t.backgroundColorTo"        => "",
                        "t.gradientDirection"         => "",
                        "t.borderTopWidth"           => "",
                        "t.borderTopLeftRadius"     => "",
                        "t.borderRightWidth"         => "",
                        "t.borderTopRightRadius"    => "",
                        "t.borderBottomWidth"        => "",
                        "t.borderBottomRightRadius" => "",
                        "t.borderLeftWidth"          => "",
                        "t.borderBottomLeftRadius"  => "",
                        "t.borderColor"               => "",
                        "t.borderStyle"               => "",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.marginTop"                 => "",
                            "outsideDesignModel.marginRight"               => "",
                            "outsideDesignModel.marginBottom"              => "",
                            "outsideDesignModel.marginLeft"                => "",
                            "outsideDesignModel.paddingTop"                => "",
                            "outsideDesignModel.paddingRight"              => "",
                            "outsideDesignModel.paddingBottom"             => "",
                            "outsideDesignModel.paddingLeft"               => "",
                            "outsideDesignModel.backgroundColorFrom"      => "",
                            "outsideDesignModel.backgroundColorTo"        => "",
                            "outsideDesignModel.gradientDirection"         => "",
                            "outsideDesignModel.borderTopWidth"           => "",
                            "outsideDesignModel.borderTopLeftRadius"     => "",
                            "outsideDesignModel.borderRightWidth"         => "",
                            "outsideDesignModel.borderTopRightRadius"    => "",
                            "outsideDesignModel.borderBottomWidth"        => "",
                            "outsideDesignModel.borderBottomRightRadius" => "",
                            "outsideDesignModel.borderLeftWidth"          => "",
                            "outsideDesignModel.borderBottomLeftRadius"  => "",
                            "outsideDesignModel.borderColor"               => "",
                            "outsideDesignModel.borderStyle"               => "",
                            // inside
                            "insideDesignModel.marginTop"                 => "",
                            "insideDesignModel.marginRight"               => "",
                            "insideDesignModel.marginBottom"              => "",
                            "insideDesignModel.marginLeft"                => "",
                            "insideDesignModel.paddingTop"                => "",
                            "insideDesignModel.paddingRight"              => "",
                            "insideDesignModel.paddingBottom"             => "",
                            "insideDesignModel.paddingLeft"               => "",
                            "insideDesignModel.backgroundColorFrom"      => "",
                            "insideDesignModel.backgroundColorTo"        => "",
                            "insideDesignModel.gradientDirection"         => "",
                            "insideDesignModel.borderTopWidth"           => "",
                            "insideDesignModel.borderTopLeftRadius"     => "",
                            "insideDesignModel.borderRightWidth"         => "",
                            "insideDesignModel.borderTopRightRadius"    => "",
                            "insideDesignModel.borderBottomWidth"        => "",
                            "insideDesignModel.borderBottomRightRadius" => "",
                            "insideDesignModel.borderLeftWidth"          => "",
                            "insideDesignModel.borderBottomLeftRadius"  => "",
                            "insideDesignModel.borderColor"               => "",
                            "insideDesignModel.borderStyle"               => "",
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
                        "t.marginBottom"              => 30,
                        "t.marginLeft"                => 40,
                        "t.paddingTop"                => 50,
                        "t.paddingRight"              => 40,
                        "t.paddingBottom"             => 30,
                        "t.paddingLeft"               => 20,
                        "t.backgroundColorFrom"      => 10,
                        "t.backgroundColorTo"        => "rgba(255,255,255,0.5)",
                        "t.gradientDirection"         => 1,
                        "t.borderTopWidth"           => 10,
                        "t.borderTopLeftRadius"     => 5,
                        "t.borderRightWidth"         => 44,
                        "t.borderTopRightRadius"    => 23,
                        "t.borderBottomWidth"        => 6,
                        "t.borderBottomRightRadius" => 4,
                        "t.borderLeftWidth"          => 7,
                        "t.borderBottomLeftRadius"  => 12,
                        "t.borderColor"               => "",
                        "t.borderStyle"               => "",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.marginTop"                 => 10,
                            "outsideDesignModel.marginRight"               => 10,
                            "outsideDesignModel.marginBottom"              => 10,
                            "outsideDesignModel.marginLeft"                => 10,
                            "outsideDesignModel.paddingTop"                => 10,
                            "outsideDesignModel.paddingRight"              => 10,
                            "outsideDesignModel.paddingBottom"             => 10,
                            "outsideDesignModel.paddingLeft"               => 10,
                            "outsideDesignModel.backgroundColorFrom"      => "rgba(255,255,255,0.5)",
                            "outsideDesignModel.backgroundColorTo"        => "rgba(0,255,255,0.5)",
                            "outsideDesignModel.gradientDirection"         => 1,
                            "outsideDesignModel.borderTopWidth"           => 20,
                            "outsideDesignModel.borderTopLeftRadius"     => 20,
                            "outsideDesignModel.borderRightWidth"         => 20,
                            "outsideDesignModel.borderTopRightRadius"    => 20,
                            "outsideDesignModel.borderBottomWidth"        => 20,
                            "outsideDesignModel.borderBottomRightRadius" => 20,
                            "outsideDesignModel.borderLeftWidth"          => 20,
                            "outsideDesignModel.borderBottomLeftRadius"  => 20,
                            "outsideDesignModel.borderColor"               => 20,
                            "outsideDesignModel.borderStyle"               => 20,
                            // inside
                            "insideDesignModel.marginTop"                 => 30,
                            "insideDesignModel.marginRight"               => 30,
                            "insideDesignModel.marginBottom"              => 30,
                            "insideDesignModel.marginLeft"                => 30,
                            "insideDesignModel.paddingTop"                => 30,
                            "insideDesignModel.paddingRight"              => 30,
                            "insideDesignModel.paddingBottom"             => 30,
                            "insideDesignModel.paddingLeft"               => 30,
                            "insideDesignModel.backgroundColorFrom"      => "",
                            "insideDesignModel.backgroundColorTo"        => "",
                            "insideDesignModel.gradientDirection"         => 0,
                            "insideDesignModel.borderTopWidth"           => 10,
                            "insideDesignModel.borderTopLeftRadius"     => 10,
                            "insideDesignModel.borderRightWidth"         => 10,
                            "insideDesignModel.borderTopRightRadius"    => 10,
                            "insideDesignModel.borderBottomWidth"        => 10,
                            "insideDesignModel.borderBottomRightRadius" => 10,
                            "insideDesignModel.borderLeftWidth"          => 10,
                            "insideDesignModel.borderBottomLeftRadius"  => 10,
                            "insideDesignModel.borderColor"               => "",
                            "insideDesignModel.borderStyle"               => "",
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
                        "t.marginBottom"              => "incorrect",
                        "t.marginLeft"                => "incorrect",
                        "t.paddingTop"                => "incorrect",
                        "t.paddingRight"              => "incorrect",
                        "t.paddingBottom"             => "incorrect",
                        "t.paddingLeft"               => "incorrect",
                        "t.backgroundColorFrom"      => "incorrect",
                        "t.backgroundColorTo"        => "incorrect",
                        "t.gradientDirection"         => "incorrect",
                        "t.borderTopWidth"           => "incorrect",
                        "t.borderTopLeftRadius"     => "incorrect",
                        "t.borderRightWidth"         => "incorrect",
                        "t.borderTopRightRadius"    => "incorrect",
                        "t.borderBottomWidth"        => "incorrect",
                        "t.borderBottomRightRadius" => "incorrect",
                        "t.borderLeftWidth"          => "incorrect",
                        "t.borderBottomLeftRadius"  => "incorrect",
                        "t.borderColor"               => "incorrect",
                        "t.borderStyle"               => "incorrect",
                    ],
                    "lines" => [
                        1 => [
                            // outside
                            "outsideDesignModel.marginTop"                 => "incorrect",
                            "outsideDesignModel.marginRight"               => "incorrect",
                            "outsideDesignModel.marginBottom"              => "incorrect",
                            "outsideDesignModel.marginLeft"                => "incorrect",
                            "outsideDesignModel.paddingTop"                => "incorrect",
                            "outsideDesignModel.paddingRight"              => "incorrect",
                            "outsideDesignModel.paddingBottom"             => "incorrect",
                            "outsideDesignModel.paddingLeft"               => "incorrect",
                            "outsideDesignModel.backgroundColorFrom"      => "incorrect",
                            "outsideDesignModel.backgroundColorTo"        => "incorrect",
                            "outsideDesignModel.gradientDirection"         => "incorrect",
                            "outsideDesignModel.borderTopWidth"           => "incorrect",
                            "outsideDesignModel.borderTopLeftRadius"     => "incorrect",
                            "outsideDesignModel.borderRightWidth"         => "incorrect",
                            "outsideDesignModel.borderTopRightRadius"    => "incorrect",
                            "outsideDesignModel.borderBottomWidth"        => "incorrect",
                            "outsideDesignModel.borderBottomRightRadius" => "incorrect",
                            "outsideDesignModel.borderLeftWidth"          => "incorrect",
                            "outsideDesignModel.borderBottomLeftRadius"  => "incorrect",
                            "outsideDesignModel.borderColor"               => "incorrect",
                            "outsideDesignModel.borderStyle"               => "incorrect",
                            // inside
                            "insideDesignModel.marginTop"                 => "incorrect",
                            "insideDesignModel.marginRight"               => "incorrect",
                            "insideDesignModel.marginBottom"              => "incorrect",
                            "insideDesignModel.marginLeft"                => "incorrect",
                            "insideDesignModel.paddingTop"                => "incorrect",
                            "insideDesignModel.paddingRight"              => "incorrect",
                            "insideDesignModel.paddingBottom"             => "incorrect",
                            "insideDesignModel.paddingLeft"               => "incorrect",
                            "insideDesignModel.backgroundColorFrom"      => "incorrect",
                            "insideDesignModel.backgroundColorTo"        => "incorrect",
                            "insideDesignModel.gradientDirection"         => "incorrect",
                            "insideDesignModel.borderTopWidth"           => "incorrect",
                            "insideDesignModel.borderTopLeftRadius"     => "incorrect",
                            "insideDesignModel.borderRightWidth"         => "incorrect",
                            "insideDesignModel.borderTopRightRadius"    => "incorrect",
                            "insideDesignModel.borderBottomWidth"        => "incorrect",
                            "insideDesignModel.borderBottomRightRadius" => "incorrect",
                            "insideDesignModel.borderLeftWidth"          => "incorrect",
                            "insideDesignModel.borderBottomLeftRadius"  => "incorrect",
                            "insideDesignModel.borderColor"               => "incorrect",
                            "insideDesignModel.borderStyle"               => "incorrect",
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