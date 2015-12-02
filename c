#!/usr/bin/env php
<?php

use system\App;

// Config file path
$config = require(__DIR__ . "/config/main.php");

// Runs a command
require(__DIR__ . "/system/App.php");
App::console($config)->run();