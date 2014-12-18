<?php

use system\App;

/**
 * Запускает web приложение
 *
 * Указывается путь до файла с настройками и передается в команду
 */

$config = require(__DIR__ . "/config/main.php");

require(__DIR__ . "/system/App.php");
App::web($config)->run();