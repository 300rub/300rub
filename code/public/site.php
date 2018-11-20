<?php

echo 321; exit;

require __DIR__ . '/../application/App.php';

use ss\application\App;

$config = include __DIR__ . '/../config/common.php';

spl_autoload_register(['ss\application\App','autoload']);

App::site($config)->run();
