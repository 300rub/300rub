<?php

namespace testS\controllers;
use testS\components\Language;

/**
 * PageController
 *
 * @package testS\controllers
 */
class PageController extends AbstractController
{

    /**
     * Static map for DEV
     *
     * @var array
     */
    private static $_pageDevStaticMap = [
        "css" => [
            "fonts/OpenSans/font",
            "lib/fa/css/font-awesome.min",
        ],
        "js" => [
            "lib/jquery.min",
            "TestS",
            "Validator",
            "Template",
            "Form",
        ],
        "less" => [
            "window",
            "login"
        ]
    ];

    /**
     * Gets login page
     *
     * @return string
     */
    public function getLoginPage()
    {
        $data = self::$_pageDevStaticMap;

        $content = "";
        if ($this->isUser()) {

        } else {
            $data["js"][] = "Login";
            $content .= $this->getContentFromTemplate("page/login");
        }

        $data["content"] = $content;

        return $this->getContentFromTemplate("page/layout", $data);
    }
}