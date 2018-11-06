<?php

use ss\application\App;

// Config file path.
$config = include __DIR__ . '/../../config/common.php';

// Runs a command.
require __DIR__ . '/../../application/App.php';

spl_autoload_register(['ss\application\App','autoload']);

App::selenium($config)->run();
