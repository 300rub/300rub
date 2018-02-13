<?php

use ss\application\App;

// Config file path
$config = include __DIR__ . "/../config/common.php";

// Runs the web application
require __DIR__ . "/../application/App.php";

spl_autoload_register(['ss\application\App','autoload']);

App::web($config)->run();