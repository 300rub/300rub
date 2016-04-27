<?php

namespace tests\unit\controllers;

use components\Language;

/**
 * Class BlockControllerTest
 *
 * @package tests\unit\controllers
 */
class BlockControllerTest extends AbstractControllerTest
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
                "block.panelList",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "handler"     => "listBlock",
                    "title"       => "Blocks",
                    "description" => "Please select any category",
                    "list"        => [
                        [
                            "label"   => "Texts",
                            "content" => "text.panelList",
                            "icon"    => "text-list-group"
                        ]
                    ],
                    "isParent"    => true
                ]
            ]
        ];
    }
}