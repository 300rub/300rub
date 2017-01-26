<?php

use testS\applications\App;

// Config file path
$config = require(__DIR__ . "/../config/main.php");

// Runs a command
require(__DIR__ . "/../applications/App.php");
App::test($config)->run();