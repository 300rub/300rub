#!/usr/bin/env php
<?php

use system\App;

/**
 * Воспроизводит команду
 *
 * Указывается путь до файла с настройками и передается в команду
 */

$config = require(__DIR__ . "/config/main.php");

require(__DIR__ . "/system/App.php");
App::console($config)->run();