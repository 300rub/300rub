<?php

namespace testS\controllers;

use testS\application\App;
use testS\components\Language;
use testS\components\Validator;
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
     * Gets login page
     *
     * @return string
     */
    public function getPage()
    {
        $isUser = $this->isUser();

        $sectionModel = (new SectionModel())->byId(1)->withRelations()->find();
        $sectionModel->setStructureAndStatic();

        $content = $this->_getCommonContent($sectionModel);

        if ($isUser) {
            $token = App::web()->getUser()->getToken();
            $content .= $this->_getUserContent();
        } else {
            $token = "";
            $content .= $this->_getGuestContent();
        }

        $content .= $this->getContentFromTemplate(
            "templates/templates",
            [
                "isUser" => $isUser
            ]
        );

        $layoutData["content"] = $content;
        $layoutData["title"] = SeoModel::getTitle();
        $layoutData["keywords"] = SeoModel::getKeywords();
        $layoutData["description"] = SeoModel::getDescription();
        $layoutData["css"] = $this->_getCss();
        $layoutData["js"] = $this->_getJs();
        $layoutData["less"] = $this->_getLess();
        $layoutData["language"] = Language::getActiveId();
        $layoutData["errorMessages"] = Validator::getErrorMessages();
        $layoutData["token"] = $token;
        $layoutData["isUser"] = $isUser;
        $layoutData["generatedCss"] = $sectionModel->getCss();

        return $this->getContentFromTemplate("page/layout", $layoutData);
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    private function _getCss()
    {
        $isUser = $this->isUser();
        $app = App::getInstance();

        $css = $app->getConfig(["staticMap", "common", "libs", "css"]);
        if ($isUser) {
            $css = array_merge($css, $app->getConfig(["staticMap", "admin", "libs", "css"]));
        }

        if (APP_ENV !== ENV_DEV) {
            $css[] = $app->getConfig(["staticMap", "common", "compiledCss"]);
            if ($isUser) {
                $css[] = $app->getConfig(["staticMap", "admin", "compiledCss"]);
            }
        }

        return $css;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    private function _getJs()
    {
        $isUser = $this->isUser();
        $app = App::getInstance();

        $js = $app->getConfig(["staticMap", "common", "libs", "js"]);
        if ($isUser) {
            $js = array_merge($js, $app->getConfig(["staticMap", "admin", "libs", "js"]));
        }

        if (APP_ENV === ENV_DEV) {
            $js = array_merge($js, $app->getConfig(["staticMap", "common", "js"]));
            if ($isUser) {
                $js = array_merge($js, $app->getConfig(["staticMap", "admin", "js"]));
            }
        } else {
            $js[] = $app->getConfig(["staticMap", "common", "compiledJs"]);
            if ($isUser) {
                $js[] = $app->getConfig(["staticMap", "admin", "compiledJs"]);
            }
        }

        return $js;
    }

    /**
     * Gets less
     *
     * @return array
     */
    private function _getLess()
    {
        if (APP_ENV !== ENV_DEV) {
            return [];
        }

        $isUser = $this->isUser();
        $app = App::getInstance();

        $less = [];

        $less[] = $app->getConfig(["staticMap", "common", "less"]);
        if ($isUser) {
            $less[] = $app->getConfig(["staticMap", "admin", "less"]);
        }

        return $less;
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