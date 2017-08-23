<?php

return [
    "common" => [
        "libs" => [
            "css" => [
                "fonts/OpenSans/font",
                "lib/fa/css/font-awesome.min",
                "lib/hover-min",
            ],
            "js"  => [
                "lib/jquery.min",
                "lib/md5.min",
            ]
        ],
        "less" => "common",
        "js"   => [
            "TestS",
            "Validator",
            "Template",
            "Ajax",
            "Form",
            "Window",
            "window/Login",
        ]
    ],
    "admin"  => [
        "libs" => [
            "css" => [
                "lib/colorpicker/jquery.colorpicker",
            ],
            "js"  => [
                "lib/jquery-ui.min",
                "lib/jquery.colorpicker",
            ]
        ],
        "less" => "admin",
        "js"   => [
            "Accordion",
            "UserButtons",
            "Panel",
            "panel/Settings",
            "panel/Block",
            "panel/Block.Text",
            "panel/design/Design",
            "panel/design/Design.Block",
            "panel/design/Design.Text",
            "window/Users",
            "window/Users.Sessions",
            "window/Users.Form",
        ]
    ],
];