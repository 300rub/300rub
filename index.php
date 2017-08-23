<?php

use testS\applications\App;

// Config file path
$config = require(__DIR__ . "/config/common.php");

// Runs the web application
require(__DIR__ . "/applications/App.php");
App::web($config)->run();