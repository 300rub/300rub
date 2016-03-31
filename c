#!/usr/bin/env php
<?php

use application\App;

// Config file path
$config = require(__DIR__ . "/config/main.php");

// Runs a command
require(__DIR__ . "/application/App.php");
App::console($config)->run();