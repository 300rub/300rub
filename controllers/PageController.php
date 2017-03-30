<?php

namespace testS\controllers;

use testS\components\Operation;
use testS\models\SeoModel;

/**
 * PageController
 *
 * @package testS\controllers
 */
class PageController extends AbstractController
{

    /**
     * Common Dev Static Map
     *
     * @var array
     */
    private static $_commonDevStaticMap = [
        "css"  => [
            "fonts/OpenSans/font",
            "lib/fa/css/font-awesome.min",
        ],
        "js"   => [
            "lib/jquery.min",
            "TestS",
            "Validator",
            "Template",
            "Form",
        ],
        "less" => [
            "window"
        ]
    ];

    /**
     * Guest Dev Static Map
     *
     * @var array
     */
    private static $_guestDevStaticMap = [
        "js"   => [
            "Login"
        ],
        "less" => [
            "login"
        ]
    ];

    /**
     * User Dev Static Map
     *
     * @var array
     */
    private static $_userDevStaticMap = [

    ];

    /**
     * Common templates map
     *
     * @var array
     */
    private static $_commonTemplatesMap = [
        "forms/text",
        "forms/password",
        "forms/checkbox",
    ];

    /**
     * Guest templates map
     *
     * @var array
     */
    private static $_guestTemplatesMap = [

    ];

    /**
     * User templates map
     *
     * @var array
     */
    private static $_userTemplatesMap = [

    ];

    /**
     * Gets login page
     *
     * @return string
     */
    public function getPage()
    {
        $content = $this->_getCommonContent();

        if ($this->isUser()) {
            $layoutData = array_merge_recursive(self::$_commonDevStaticMap, self::$_userDevStaticMap);
            $templatesMap = array_merge(self::$_commonTemplatesMap, self::$_userTemplatesMap);

            $content .= $this->_getUserContent();
        } else {
            $layoutData = array_merge_recursive(self::$_commonDevStaticMap, self::$_guestDevStaticMap);
            $templatesMap = array_merge(self::$_commonTemplatesMap, self::$_guestTemplatesMap);

            $content .= $this->_getGuestContent();
        }

        $content .= $this->getContentFromTemplate("templates/templates", ["templates" => array_unique($templatesMap)]);

        $layoutData["content"] = $content;
        $layoutData["title"] = SeoModel::getTitle();
        $layoutData["keywords"] = SeoModel::getKeywords();
        $layoutData["description"] = SeoModel::getDescription();

        return $this->getContentFromTemplate("page/layout", $layoutData);
    }

    /**
     * Gets common content
     *
     * @return string
     */
    private function _getCommonContent()
    {
        SeoModel::setTitle("title");
        SeoModel::setKeywords("keywords");
        SeoModel::setDescription("description");

        return "";
    }

    /**
     * Gets content for guest only
     *
     * @return string
     */
    private function _getGuestContent()
    {
        return $this->getContentFromTemplate("page/loginButton");
    }

    /**
     * Gets content for user only
     *
     * @return string
     */
    private function _getUserContent()
    {
        $isDisplaySections = false;
        $isDisplayBlocks = false;
        $isDisplaySettings = false;

        if ($this->getUserIsOwner() === true) {
            $isDisplaySections = true;
            $isDisplayBlocks = true;
            $isDisplaySettings = true;
        } else {
            $operations = $this->getUserOperations();

            if (array_key_exists(Operation::TYPE_SECTIONS, $operations)) {
                $isDisplaySections = true;
            }

            if (array_key_exists(Operation::TYPE_BLOCKS, $operations)) {
                $isDisplayBlocks = true;
            }

            if (array_key_exists(Operation::TYPE_SETTINGS, $operations)) {
                $isDisplaySettings = true;
            }
        }

        return $this->getContentFromTemplate(
            "page/userButtons",
            [
                "isDisplaySections" => $isDisplaySections,
                "isDisplayBlocks"   => $isDisplayBlocks,
                "isDisplaySettings" => $isDisplaySettings,
            ]
        );
    }
}