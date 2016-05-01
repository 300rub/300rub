<?php

namespace tests\unit\controllers;

use components\Language;

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
            $this->_dataProviderForActionContent()
//            $this->_dataProviderForActionPanelList(),
//            $this->_dataProviderForActionSettings(),
//            $this->_dataProviderForActionSaveSettings(),
//            $this->_dataProviderForActionDesign(),
//            $this->_dataProviderForActionSaveDesign(),
//            $this->_dataProviderForActionWindow(),
//            $this->_dataProviderForActionSaveWindow()
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
                        '<div class="design-text-1 design-block-1"style="font-weight: normal; line-height: 140%;">' .
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
                    //
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
                    //
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
                    //
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
                        //
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
                    //
                ],
                [
                    ///
                ]
            ],
            // With correct all data
            [
                "text.saveSettings",
                Language::LANGUAGE_EN_ALIAS,
                [
                    //
                ],
                [
                    //
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
                    //
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
                    "id" => 1,
                    //
                ],
                [
                    //
                ]
            ],
            // Correct values
            [
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1,
                    //
                ],
                [
                    //
                ]
            ],
            // Incorrect values
            [
                "text.saveDesign",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "id" => 1,
                    //
                ],
                [
                    //
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
                    "id" => "sdfsdfs"
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
                    //
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
                    "id" => "1",
                   //
                ],
                [
                   //
                ]
            ],
        ];
    }
}