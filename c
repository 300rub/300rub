#!/usr/bin/env php
<?php

use applications\App;

// Config file path
$config = require(__DIR__ . "/config/main.php");

// Runs a command
require(__DIR__ . "/applications/App.php");
App::console($config)->run();