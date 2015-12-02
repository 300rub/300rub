<?php

use system\App;

// Config file path
$config = require(__DIR__ . "/config/main.php");

// Runs the web application
require(__DIR__ . "/system/App.php");
App::web($config)->run();