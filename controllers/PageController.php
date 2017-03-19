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
            "fonts/OpenSans/font"
        ],
        "js" => [
            "lib/jquery.min",
            "TestS",
            "Login",
            "forms/Form",
            "forms/Text",
            "forms/Password",
            "forms/Checkbox",
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