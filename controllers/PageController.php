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
     * Static map for DEV login
     *
     * @var array
     */
    private static $_loginDevStaticMap = [
        "css" => [
            "fonts/OpenSans/font",
            "lib/fa/css/font-awesome.min",
        ],
        "js" => [
            "lib/jquery.min",
            "TestS",
            "Login",
            "Validator",
            "Template",
            "Form",
        ],
        "less" => [
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
        $data = self::$_loginDevStaticMap;

        $data["content"] = $this->getContentFromTemplate("page/login", [
            "h1" => Language::t("user", "loginH1")
        ]);

        return $this->getContentFromTemplate("page/layout", $data);
    }
}