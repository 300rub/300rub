<?php

use applications\App;

// Config file path
$config = require(__DIR__ . "/config/main.php");

// Runs the web application
require(__DIR__ . "/application/App.php");
App::web($config)->run();