<?php

use system\App;
require(__DIR__ . "/system/App.php");

/**
 * Подключает и инициализирует приложение
 *
 * Указывается путь до файла с настройками и передается в приложение
 */

App::run(__DIR__ . "/config/main.php");