<?php

use application\App;

require("errors.php");
require("window/window.php");
require("window/window.login.php");

if (App::web()->user !== null) {
    require("help.php");
    require("window/window.section.php");
    require("window/window.text.php");
    require("panel/panel.php");
    require("panel/panel.list.php");
    require("panel/panel.settings.php");
    require("panel/panel.settings.section.php");
    require("panel/panel.settings.text.php");
    require(__DIR__ . "/../design/block_forms.php");
    require(__DIR__ . "/../design/text_forms.php");
}