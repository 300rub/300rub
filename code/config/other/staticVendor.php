<?php

$fortawesome = "fortawesome/font-awesome/web-fonts-with-css";

$commonCss = [
    "fa/css/fontawesome-all.min.css"
        => $fortawesome . "/css/fontawesome-all.min.css",
    "jquery.fancybox.min.css"
        => "fancyapps/fancybox/dist/jquery.fancybox.min.css",
];

$commonJs = [
    "jquery/jquery.min.js"
        => "components/jquery/jquery.min.js",
    "jquery.fancybox.min.js"
        => "fancyapps/fancybox/dist/jquery.fancybox.min.js",
    "jssor.slider.min.js"
        => "jssor/slider/js/jssor.slider.min.js",
];

$commonFiles = [
    "fa/webfonts/fa-brands-400.eot"
        => $fortawesome . "/webfonts/fa-brands-400.eot",
    "fa/webfonts/fa-brands-400.svg"
        => $fortawesome . "/webfonts/fa-brands-400.svg",
    "fa/webfonts/fa-brands-400.ttf"
        => $fortawesome . "/webfonts/fa-brands-400.ttf",
    "fa/webfonts/fa-brands-400.woff"
        => $fortawesome . "/webfonts/fa-brands-400.woff",
    "fa/webfonts/fa-brands-400.woff2"
        => $fortawesome . "/webfonts/fa-brands-400.woff2",
    "fa/webfonts/fa-regular-400.eot"
        => $fortawesome . "/webfonts/fa-regular-400.eot",
    "fa/webfonts/fa-regular-400.svg"
        => $fortawesome . "/webfonts/fa-regular-400.svg",
    "fa/webfonts/fa-regular-400.ttf"
        => $fortawesome . "/webfonts/fa-regular-400.ttf",
    "fa/webfonts/fa-regular-400.woff"
        => $fortawesome . "/webfonts/fa-regular-400.woff",
    "fa/webfonts/fa-regular-400.woff2"
        => $fortawesome . "/webfonts/fa-regular-400.woff2",
    "fa/webfonts/fa-solid-900.eot"
        => $fortawesome . "/webfonts/fa-solid-900.eot",
    "fa/webfonts/fa-solid-900.svg"
        => $fortawesome . "/webfonts/fa-solid-900.svg",
    "fa/webfonts/fa-solid-900.ttf"
        => $fortawesome . "/webfonts/fa-solid-900.ttf",
    "fa/webfonts/fa-solid-900.woff"
        => $fortawesome . "/webfonts/fa-solid-900.woff",
    "fa/webfonts/fa-solid-900.woff2"
        => $fortawesome . "/webfonts/fa-solid-900.woff2",
];

$adminCss = [
    "gridstack.min.css"
        => "troolee/gridstack/dist/gridstack.min.css",
    "colorpicker/jquery.colorpicker.css"
        => "vanderlee/colorpicker/jquery.colorpicker.css",
    "cropper.min.css"
        => "fengyuanchen/cropper/dist/cropper.min.css",
];

$adminJs = [
    "jquery-ui.min.js"
        => "components/jqueryui/jquery-ui.min.js",
    "underscore-min.js"
        => "components/underscore/underscore-min.js",
    "gridstack.min.js"
        => "troolee/gridstack/dist/gridstack.min.js",
    "jquery.colorpicker.js"
        => "vanderlee/colorpicker/jquery.colorpicker.js",
    "tinymce/tinymce.min.js"
        => "tinymce/tinymce/tinymce.min.js",
    "tinymce/jquery.tinymce.min.js"
        => "tinymce/tinymce/jquery.tinymce.min.js",
    "cropper.min.js"
        => "fengyuanchen/cropper/dist/cropper.min.js",
];

$adminFiles = [
    "underscore-min.map"
        => "components/underscore/underscore-min.map",
    "colorpicker/images/bar.png"
        => "vanderlee/colorpicker/images/bar.png",
    "colorpicker/images/bar-alpha.png"
        => "vanderlee/colorpicker/images/bar-alpha.png",
    "colorpicker/images/bar-opacity.png"
        => "vanderlee/colorpicker/images/bar-opacity.png",
    "colorpicker/images/bar-pointer.png"
        => "vanderlee/colorpicker/images/bar-pointer.png",
    "colorpicker/images/map.png"
        => "vanderlee/colorpicker/images/map.png",
    "colorpicker/images/map-opacity.png"
        => "vanderlee/colorpicker/images/map-opacity.png",
    "colorpicker/images/map-pointer.png"
        => "vanderlee/colorpicker/images/map-pointer.png",
    "colorpicker/images/preview-opacity.png"
        => "vanderlee/colorpicker/images/preview-opacity.png",
    "colorpicker/images/ui-colorpicker.png"
        => "vanderlee/colorpicker/images/ui-colorpicker.png",
    "gridstack.min.map"
        => "troolee/gridstack/dist/gridstack.min.map",
    "tinymce/themes/modern/theme.min.js"
        => "tinymce/tinymce/themes/modern/theme.min.js",
    "tinymce/skins/lightgray/skin.min.css"
        => "tinymce/tinymce/skins/lightgray/skin.min.css",
    "tinymce/skins/lightgray/content.min.css"
        => "tinymce/tinymce/skins/lightgray/content.min.css",
    "tinymce/skins/lightgray/fonts/tinymce.woff"
        => "tinymce/tinymce/skins/lightgray/fonts/tinymce.woff",
    "tinymce/skins/lightgray/fonts/tinymce.ttf"
        => "tinymce/tinymce/skins/lightgray/fonts/tinymce.ttf",
    "tinymce/skins/lightgray/img/loader.gif"
        => 'tinymce/tinymce/skins/lightgray/img/loader.gif',
    "tinymce/plugins/textcolor/plugin.min.js"
        => "tinymce/tinymce/plugins/textcolor/plugin.min.js",
    "tinymce/plugins/link/plugin.min.js"
        => "tinymce/tinymce/plugins/link/plugin.min.js",
    "tinymce/plugins/hr/plugin.min.js"
        => "tinymce/tinymce/plugins/hr/plugin.min.js",
    "tinymce/plugins/image/plugin.min.js"
        => "tinymce/tinymce/plugins/image/plugin.min.js",
    "tinymce/plugins/imagetools/plugin.min.js"
        => "tinymce/tinymce/plugins/imagetools/plugin.min.js",
    "tinymce/plugins/charmap/plugin.min.js"
        => "tinymce/tinymce/plugins/charmap/plugin.min.js",
    "tinymce/plugins/print/plugin.min.js"
        => "tinymce/tinymce/plugins/print/plugin.min.js",
    "tinymce/plugins/preview/plugin.min.js"
        => "tinymce/tinymce/plugins/preview/plugin.min.js",
    "tinymce/plugins/fullscreen/plugin.min.js"
        => "tinymce/tinymce/plugins/fullscreen/plugin.min.js",
    "tinymce/plugins/table/plugin.min.js"
        => "tinymce/tinymce/plugins/table/plugin.min.js",
];

$siteCss = [];
$siteJs = [];
$siteFiles = [];

return [
    'common' => [
        "css"   => $commonCss,
        "js"    => $commonJs,
        "files" => $commonFiles,
    ],
    'admin' => [
        "css"   => $adminCss,
        "js"    => $adminJs,
        "files" => $adminFiles,
    ],
    'site' => [
        "css"   => $siteCss,
        "js"    => $siteJs,
        "files" => $siteFiles,
    ]
];
