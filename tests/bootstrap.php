<?php

use testS\application\App;

// Config file path
$config = require(__DIR__ . "/../config/common.php");

// Runs a command
require(__DIR__ . "/../application/App.php");
App::test($config)->run();