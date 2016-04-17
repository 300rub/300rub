<?php

// Map for compressing static
return [
    "common" => [
        "less" => [
            "common.less",
        ],
        "css" => [],
        "js" => [
            "lib/jquery.min.js",
            "core.js",
            "functions.js",
            "ajax.json.js",
            "form.js",
            "validator.js",
            "window/window.js",
            "window/window.login.js",
            "handler.js",
        ],
    ],
    "admin" => [
        "less" => [
            "admin.less",
        ],
        "css"  => [
            "lib/gridstack.min.css",
            "lib/colorpicker/jquery.colorpicker.css",
        ],
        "js"  => [
            "lib/jquery-ui.min.js",
            "lib/lodash.min.js",
            "lib/gridstack.min.js",
            "lib/jquery.colorpicker.js",
            "lib/tinymce/tinymce.jquery.min.js",
            "admin.js",
            "panel/panel.js",
            "panel/panel.design.js",
            "panel/panel.list.js",
            "panel/panel.list.section.js",
            "panel/panel.payment.js",
            "panel/panel.settings.js",
            "panel/panel.settings.section.js",
            "panel/panel.settings.text.js",
            "window/window.section.js",
            "window/window.text.js",
            "design.js",
            "help.js",
        ]
    ]
];