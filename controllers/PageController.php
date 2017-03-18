<?php

namespace testS\controllers;

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

        $data["content"] = $this->getContentFromTemplate("page/login");

        return $this->getContentFromTemplate("page/layout", $data);
    }
}