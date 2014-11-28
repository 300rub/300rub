#!/usr/bin/env php
<?php

use system\console\CommandRunner;
require(__DIR__ . "/system/console/Command.php");
require(__DIR__ . "/system/console/CommandRunner.php");

/**
 * Воспроизводит команду
 *
 * Указывается путь до файла с настройками и передается в команду
 */

var_dump($_SERVER); exit();
new CommandRunner(__DIR__ . "/config/main.php");