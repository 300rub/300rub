<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\Language;
use testS\components\Validator;
use testS\models\AbstractContentModel;
use testS\models\SectionModel;
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
            "lib/hover-min",
        ],
        "js"   => [
            "lib/jquery.min",
            "lib/md5.min",
            "TestS",
            "Validator",
            "Template",
            "Ajax",
            "Form",
            "Window",
            "window/Login",
        ],
        "less" => [
            "default",
            "grid",
            "form",
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
        "js" => [
            "Accordion",
            "Panel",
            "panel/Settings",
            "panel/Block",
            "panel/Design",
            "panel/design/Block",
            "UserButtons",
            "window/Users",
            "window/Users.Sessions",
            "window/Users.Form",
        ],
        "less" => [
            "userButtons",
            "panel"
        ]
    ];

    /**
     * Common templates map
     *
     * @var array
     */
    private static $_commonTemplatesMap = [
        "common/ajax-error",
        "common/accordion",
        "common/forms",
        "window/window"
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
        "panel/panel",
        "panel/design/block",
        "window/users"
    ];

    /**
     * Gets login page
     *
     * @return string
     */
    public function getPage()
    {
        $sectionModel = (new SectionModel())->byId(1)->withRelations()->find();
        $sectionModel->setStructureAndStatic();

        $content = $this->_getCommonContent($sectionModel);
        $isUser = $this->isUser();

        if ($isUser) {
            $token = App::web()->getUser()->getToken();
            $layoutData = array_merge_recursive(self::$_commonDevStaticMap, self::$_userDevStaticMap);
            $templatesMap = array_merge(self::$_commonTemplatesMap, self::$_userTemplatesMap);

            $content .= $this->_getUserContent();
        } else {
            $token = "";
            $layoutData = array_merge_recursive(self::$_commonDevStaticMap, self::$_guestDevStaticMap);
            $templatesMap = array_merge(self::$_commonTemplatesMap, self::$_guestTemplatesMap);

            $content .= $this->_getGuestContent();
        }

        $content .= $this->getContentFromTemplate("templates/templates", ["templates" => array_unique($templatesMap)]);

        $layoutData["content"] = $content;
        $layoutData["title"] = SeoModel::getTitle();
        $layoutData["keywords"] = SeoModel::getKeywords();
        $layoutData["description"] = SeoModel::getDescription();
        $layoutData["language"] = Language::getActiveId();
        $layoutData["errorMessages"] = Validator::getErrorMessages();
        $layoutData["token"] = $token;
        $layoutData["isUser"] = $isUser;
        $layoutData["generatedCss"] = $sectionModel->getCss();

        return $this->getContentFromTemplate("page/layout", $layoutData);
    }

    /**
     * Gets common content
     *
     * @param SectionModel $sectionModel
     *
     * @return string
     */
    private function _getCommonContent($sectionModel)
    {
        SeoModel::setTitle("title");
        SeoModel::setKeywords("keywords");
        SeoModel::setDescription("description");

        $structure = $sectionModel->getStructure();

        $lineHtml = "";
        foreach ($structure as $line => $lineStructure) {
            $lineHtml .= $this->getContentFromTemplate(
                "page/line",
                [
                    "id"        => $line,
                    "structure" => $lineStructure
                ]
            );
        }

        return $this->getContentFromTemplate(
            "page/section",
            [
                "id"      => $sectionModel->getId(),
                "content" => $lineHtml
            ]
        );
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
        return $this->getContentFromTemplate(
            "page/userButtons",
            [
                "isDisplaySections" => $this->hasAnySectionOperations(),
                "isDisplayBlocks"   => $this->hasAnyBlockOperations(),
                "logoutYes"         => Language::t("user", "logoutYes"),
                "logoutNo"          => Language::t("user", "logoutNo"),
                "logoutConfirmText" => Language::t("user", "logoutConfirmText")
            ]
        );
    }
}